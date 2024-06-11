<?php

namespace App\Controllers;

use \Firebase\JWT\JWT;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;

class AuthController extends BaseController
{
    use ResponseTrait;

    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        try {
            $userModel = new UserModel();

            $email = $this->request->getVar('email');
            $password = $this->request->getVar('password');

            $user = $userModel->where('email', $email)->first();

            if (is_null($user)) {
                return $this->respond(['error' => 'Invalid username or password.'], 401);
            }

            if (!$user['is_active']) {
                return $this->respond(['error' => 'Account is not activated. Please check your email.'], 401);
            }

            $pwd_verify = password_verify($password, $user['password']);

            if (!$pwd_verify) {
                return $this->respond(['error' => 'Invalid username or password.'], 401);
            }

            $key = getenv('JWT_SECRET');
            $iat = time(); // current timestamp value
            $exp = $iat + 3600;

            $payload = array(
                "iss" => "Issuer of the JWT",
                "aud" => "Audience that the JWT",
                "sub" => "Subject of the JWT",
                "iat" => $iat, //Time the JWT issued at
                "exp" => $exp, // Expiration time of token
                "email" => $user['email'],
            );

            $token = JWT::encode($payload, $key, 'HS256');

            $response = [
                'message' => 'Login Succesful',
                'token' => $token,
                'user' => $user
            ];

            return $this->respond($response, 200);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return $this->fail('An error occurred: ' . $e->getMessage(), 500);
        }
    }


    public function register()
    {
        try {
            // Génération du jeton d'activation
            $activationToken = bin2hex(random_bytes(16));

            $data = [
                'nom' => $this->request->getVar('nom'),
                'numero' => $this->request->getVar('numero'),
                'adresse' => $this->request->getVar('adresse'),
                'email' => $this->request->getVar('email'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'activation_token' => $activationToken,  // Stocker le jeton d'activation
                'is_active' => 0 // Compte non activé par défaut
            ];

            if (!$this->userModel->insert($data)) {
                log_message('error', 'User registration failed');
                return $this->fail('User registration failed', 500);
            }

            // Récupérer l'ID de l'utilisateur nouvellement créé
            $userId = $this->userModel->getInsertID();
            $user = $this->userModel->find($userId);

            log_message('debug', 'User registered successfully with ID: ' . $userId . ' and token: ' . $activationToken);

            // URL d'activation
            $activationUrl = base_url("api/auth/activate/" . $activationToken);
            log_message('debug', 'Activation URL: ' . $activationUrl);

            // Envoyer l'email d'activation
            $emailService = \Config\Services::email();
            $emailService->setTo($user['email']);
            $emailService->setSubject('Account Activation');
            $emailService->setMessage("Veuillez cliquer sur le lien suivant pour activer votre compte: $activationUrl");

            if (!$emailService->send()) {
                log_message('error', 'Failed to send activation email to: ' . $user['email']);
                return $this->fail('Failed to send activation email', 500);
            }

            return $this->respond(['message' => 'Inscription avec succès. Veuillez vérifier votre e-mail pour activer votre compte. ']);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return $this->fail('An error occurred: ' . $e->getMessage(), 500);
        }
    }



    public function activate($token)
    {
        try {
            $user = $this->userModel->where('activation_token', $token)->first();

            if (!$user) {
                return $this->failNotFound(' activation token invalide');
            }

            $this->userModel->update($user['id'], [
                'is_active' => 1,
                'activation_token' => null  // Supprimer le token d'activation
            ]);

            return $this->respond(['message' => 'Compte activé avec succès']);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return $this->fail('An error occurred: ' . $e->getMessage(), 500);
        }
    }






    public function show($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return $this->failNotFound('User not found');
        }

        return $this->respond($user);
    }

    public function update($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return $this->failNotFound('User not found');
        }

        $nom = $this->request->getVar('nom');
        $numero = $this->request->getVar('numero');
        $adresse = $this->request->getVar('adresse');
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $data = [];

        if ($nom !== null) {
            $data['nom'] = $nom;
        }
        if ($numero !== null) {
            $data['numero'] = $numero;
        }
        if ($adresse !== null) {
            $data['adresse'] = $adresse;
        }
        if ($password !== null) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $data);

        $updatedUser = $this->userModel->find($id);

        return $this->respond(['message' => 'User information updated successfully', 'user' => $updatedUser]);
    }



    public function forgotPassword()
    {
        try {
            $email = $this->request->getVar('email');
            $user = $this->userModel->where('email', $email)->first();

            if (!$user) {
                return $this->respond(['error' => 'Email not found'], 404);
            }

            $resetToken = bin2hex(random_bytes(16));
            $this->userModel->update($user['id'], ['reset_token' => $resetToken]);

            $emailService = \Config\Services::email();
            $emailService->setTo($email);
            $emailService->setSubject('Password Reset');
            $emailService->setMessage("Please use the following token to reset your password: $resetToken");
            $emailService->send();

            return $this->respond(['message' => 'Password reset token sent']);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return $this->fail('An error occurred: ' . $e->getMessage(), 500);
        }
    }

    public function resetPassword()
    {
        try {
            $resetToken = $this->request->getVar('reset_token');
            $newPassword = $this->request->getVar('password');

            $user = $this->userModel->where('reset_token', $resetToken)->first();

            if (!$user) {
                return $this->respond(['error' => 'Invalid token'], 400);
            }

            $this->userModel->update($user['id'], [
                'password' => password_hash($newPassword, PASSWORD_DEFAULT),
                'reset_token' => null
            ]);

            return $this->respond(['message' => 'Password reset successfully']);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return $this->fail('An error occurred: ' . $e->getMessage(), 500);
        }
    }

    public function changePassword()
    {
        try {
            $userId = $this->request->getVar('user_id');
            $currentPassword = $this->request->getVar('current_password');
            $newPassword = $this->request->getVar('new_password');

            $user = $this->userModel->find($userId);

            if (!$user) {
                return $this->failNotFound('User not found');
            }

            if (!password_verify($currentPassword, $user['password'])) {
                return $this->respond(['error' => 'Current password is incorrect'], 400);
            }

            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            $this->userModel->update($userId, ['password' => $hashedNewPassword]);

            // Configuration de l'email
            $email = \Config\Services::email();

            // $email->setFrom('lawsonlatevi005@gmail.com', 'Mercato');
            $email->setTo($user['email']);
            $email->setSubject('Changement de mot de passe');
            $email->setMessage('Bonjour ' . $user['nom'] . ',<br><br>Votre mot de passe a été changé avec succès.<br><br>Si vous n\'êtes pas à l\'origine de cette modification, veuillez contacter notre support immédiatement.');

            if ($email->send()) {
                return $this->respond(['message' => 'Password changed successfully and email sent'], 200);
            } else {
                $data = $email->printDebugger(['headers']);
                return $this->respond(['message' => 'Password changed successfully, but email could not be sent', 'error' => $data], 200);
            }
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return $this->fail('An error occurred: ' . $e->getMessage(), 500);
        }
    }
}

<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use Config\Services;

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
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $user = $this->userModel->where('email', $email)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return $this->failUnauthorized('Invalid email or password');
        }

        $jwt = Services::jwt();

        $iat = time();
        $exp = $iat + 3600;

        $payload = [
            'iat' => $iat,
            'exp' => $exp,
            'user_id' => $user['id'],
            'email' => $user['email'],
        ];

        $token = $jwt->encode($payload);

        return $this->respond([
            'message' => 'Login successful',
            'token' => $token,
        ]);
    }

    public function register()
    {
        $data = [
            'nom' => $this->request->getVar('nom'),
            'role' => $this->request->getVar('role'),
            'numero' => $this->request->getVar('numero'),
            'email' => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
        ];

        $this->userModel->insert($data);

        return $this->respond(['message' => 'User registered successfully']);
    }

    public function profile()
    {
        $token = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$token) {
            return $this->failUnauthorized('Token is missing');
        }

        $jwt = Services::jwt();

        try {
            $decoded = $jwt->decode($token);
            $userId = $decoded->user_id;
        } catch (\Exception $e) {
            return $this->failUnauthorized('Invalid token');
        }

        $user = $this->userModel->find($userId);

        if (!$user) {
            return $this->failNotFound('User not found');
        }

        unset($user['password']);

        return $this->respond($user);
    }
}

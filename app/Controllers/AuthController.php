<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use \Firebase\JWT\JWT;

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
      
            if(is_null($user)) {
                return $this->respond(['error' => 'Invalid username or password.'], 401);
            }
      
            $pwd_verify = password_verify($password, $user['password']);
      
            if(!$pwd_verify) {
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
                'token' => $token
            ];
             
            return $this->respond($response, 200);
        }
     catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return $this->fail('An error occurred: ' . $e->getMessage(), 500);
        }
    }

    public function register()
    {
        try {
            $data = [
                'nom' => $this->request->getVar('nom'),
                'numero' => $this->request->getVar('numero'),
                'adresse' => $this->request->getVar('adresse'),
                'email' => $this->request->getVar('email'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            ];

            $this->userModel->insert($data);

            return $this->respond(['message' => 'User registered successfully']);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return $this->fail('An error occurred: ' . $e->getMessage(), 500);
        }
    }

    // public function profile()
    // {
    //     try {
    //         $token = $this->request->getServer('HTTP_AUTHORIZATION');
    //         if (!$token) {
    //             return $this->failUnauthorized('Token is missing');
    //         }

    //         $key = "mon_code_keys";
    //         $decoded = JWT::decode($token, $key, ['HS256']);
    //         $userId = $decoded->user_id;

    //         $user = $this->userModel->find($userId);

    //         if (!$user) {
    //             return $this->failNotFound('User not found');
    //         }

    //         unset($user['password']);

    //         return $this->respond($user);
    //     } catch (\Exception $e) {
    //         log_message('error', $e->getMessage());
    //         return $this->fail('An error occurred: ' . $e->getMessage(), 500);
    //     }
    // }
}

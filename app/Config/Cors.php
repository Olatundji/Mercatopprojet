<?php

namespace Config;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Cors implements FilterInterface
{
    public function before(RequestInterface $request,$arguments=null)
    {
        // Récupérer les informations sur l'origine de la requête
        $origin = $request->getHeaderLine('Origin');

        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: *");
        header("Access-Control-Allow-Credentials: true");

        if ($request->getMethod() === 'OPTIONS') {
            exit();
        }

    }

    public function after(RequestInterface $request, ResponseInterface $response,$arguments=null)
    {
        $response = $response->setHeader('X-Content-Type-Options', 'nosniff');

        $response = $response->setHeader('Access-Control-Allow-Origin', '*');

        return $response;
    }
}

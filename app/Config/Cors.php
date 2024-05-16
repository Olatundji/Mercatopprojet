<?php


namespace Config;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Cors implements FilterInterface
{
    public function before(RequestInterface $request,$arguments=null)
    {
        $origin = $request->getHeaderLine('Origin');

        header('Access-Control-Allow-Origin: http://localhost:3000');
        header('Access-Control-Allow-Credentials: true'); 
        header('Access-Control-Allow-Headers: X-API-KEY, Origin, Authorization, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

        if ($request->getMethod() === 'OPTIONS') {
            exit();
        }
        }

    public function after(RequestInterface $request, ResponseInterface $response,$arguments=null)
    {
        $response = $response->setHeader('X-Content-Type-Options', 'nosniff');
        // $response = $response->setHeader('Access-Control-Allow-Origin', '*');

        // Retourner la réponse mise à jour
        return $response;
    }
}

<?php

namespace Config;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Cors implements FilterInterface
{
    private $allowedOrigins = [
        'https://mercatop.lemeilleurcointech.com',
        'http://mercatop.lemeilleurcointech.com', 
    ];

    public function before(RequestInterface $request, $arguments = null)
    {
        $origin = $request->getHeaderLine('Origin');

        if (in_array($origin, $this->allowedOrigins)) {
            header('Access-Control-Allow-Origin: ' . $origin);
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Allow-Headers: X-API-KEY, Origin, Authorization, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method');
            header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        }

        if ($request->getMethod() === 'OPTIONS') {
            exit();
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $origin = $request->getHeaderLine('Origin');

        if (in_array($origin, $this->allowedOrigins)) {
            $response = $response->setHeader('Access-Control-Allow-Origin', $origin)
                                 ->setHeader('Access-Control-Allow-Credentials', 'true')
                                 ->setHeader('Access-Control-Allow-Headers', 'X-API-KEY, Origin, Authorization, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method')
                                 ->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        }

        $response = $response->setHeader('X-Content-Type-Options', 'nosniff');

        return $response;
    }
}

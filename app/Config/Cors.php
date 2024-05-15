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

        header('Access-Control-Allow-Origin: ' . $origin);

        header('Access-Control-Allow-Headers: Content-Type, Authorization');

        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

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

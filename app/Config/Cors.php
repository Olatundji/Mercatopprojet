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

        // Autoriser l'origine spécifiée à accéder à votre API
        header('Access-Control-Allow-Origin: ' . $origin);

        // Autoriser certains en-têtes spécifiques
        header('Access-Control-Allow-Headers: Content-Type, Authorization');

        // Autoriser certains méthodes HTTP
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

        // Vérifier si la méthode de la requête est OPTIONS (pour les pré-vérifications CORS)
        if ($request->getMethod() === 'OPTIONS') {
            // Renvoyer une réponse HTTP 200 avec les en-têtes CORS appropriés
            exit();
        }

        // Si la méthode de la requête n'est pas OPTIONS, laissez la requête passer
    }

    public function after(RequestInterface $request, ResponseInterface $response,$arguments=null)
    {
        // Ajouter des en-têtes supplémentaires à la réponse si nécessaire
        $response = $response->setHeader('X-Content-Type-Options', 'nosniff');

        // Ajouter un en-tête CORS pour permettre l'accès à partir de n'importe quelle origine
        $response = $response->setHeader('Access-Control-Allow-Origin', '*');

        // Retourner la réponse modifiée
        return $response;
    }
}

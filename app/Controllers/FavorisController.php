<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use App\Models\FavorisModel; // Importez le modèle FavorisModel

class FavorisController extends BaseController
{
    protected $session;
    protected $favorisModel; // Déclarez la propriété pour le modèle FavorisModel

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->session->start();
        $this->favorisModel = new FavorisModel();
    }

    public function addFavorite($productId)
    {
        $userId = $this->getCurrentUserId();

        // Vérifier si l'utilisateur est connecté
        if (!$userId) {
            return $this->failUnauthorized('Vous devez être connecté pour ajouter des produits aux favoris.');
        }

        $this->favorisModel->addFavorite($userId, $productId);
        return $this->respond(['message' => 'Le produit a été ajouté aux favoris avec succès.']);
    }

    private function getCurrentUserId()
    {

        return $this->session->userdata('user_id');
    }
}

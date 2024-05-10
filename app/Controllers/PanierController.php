<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;

class PanierController extends BaseController {
  

    use ResponseTrait;
    
    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->session->start();
    }

    
    public function ajouterProduit() {
        $produit = [
            'id' => 1,
            'nom' => 'Produit 1',
            'prix' => 10.99,
            'quantite' => 1
        ];

        $panier = $this->session->get('panier') ?? [];

        $panier[] = $produit;

        $this->session->set('panier', $panier);

        return $this->respond(['message' => 'Produit ajouté au panier avec succès']);
    }

    public function consulterPanier() {
        $panier = $this->session->get('panier') ?? [];

        return $this->respond($panier);
    }

    public function modifierProduit($idProduit) {
    }

    public function supprimerProduit($idProduit) {
    }

    public function viderPanier() {
        $this->session->remove('panier');

        return $this->respond(['message' => 'Panier vidé avec succès']);
    }
}

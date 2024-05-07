<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;

class PanierController extends BaseController {
  

    use ResponseTrait;
    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    // Code pour ajouter un produit au panier
    
    public function ajouterProduit() {
        // Simuler les données du produit ajouté (à remplacer par la logique réelle)
        $produit = [
            'id' => 1,
            'nom' => 'Produit 1',
            'prix' => 10.99,
            'quantite' => 1
        ];

        // Récupérer le contenu actuel du panier depuis la session
        $panier = $this->session->get('panier') ?? [];

        // Ajouter le produit au panier
        $panier[] = $produit;

        // Mettre à jour le panier dans la session
        $this->session->set('panier', $panier);

        // Retourner une réponse JSON
        return $this->respond(['message' => 'Produit ajouté au panier avec succès']);
    }

    // Code pour récupérer le contenu actuel du panier
    public function consulterPanier() {
        // Récupérer le contenu actuel du panier depuis la session
        $panier = $this->session->get('panier') ?? [];

        // Retourner le contenu du panier en réponse JSON
        return $this->respond($panier);
    }

    // Code pour modifier la quantité d'un produit dans le panier
    public function modifierProduit($idProduit) {
        // Code à implémenter
    }

    // Code pour supprimer un produit du panier
    public function supprimerProduit($idProduit) {
        // Code à implémenter
    }

    // Code pour vider complètement le panier
    public function viderPanier() {
        // Supprimer le contenu du panier de la session
        $this->session->remove('panier');

        // Retourner une réponse JSON
        return $this->respond(['message' => 'Panier vidé avec succès']);
    }
}

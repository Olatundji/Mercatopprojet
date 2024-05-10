<?php

namespace App\Controllers;

use App\Models\CommandeModel;
use CodeIgniter\API\ResponseTrait;

class CommandeController extends BaseController {

    use ResponseTrait;
    protected $session;

    protected $commandeModel;

    public function __construct() {
        $this->commandeModel = new CommandeModel();
        $this->session = \Config\Services::session();
        $this->session->start(); // Démarrer manuellement les sessions
    }
    // public function restricted_function() {
    //     // Vérifier l'authentification avant d'accéder à cette fonction
    //     $this->authenticate();

    //     // Si l'utilisateur est authentifié, continuez avec la logique de votre fonction ici
    // }

    // Code pour créer une nouvelle commande en finalisant le panier
    public function nouvelleCommande() {
        $userId = user_id(); 

        $panier = $this->session->get('panier') ?? [];

        // Vérifier si le panier est vide
        if (empty($panier)) {
            return $this->fail('Le panier est vide. Ajoutez des produits avant de passer une commande.');
        }

        // Créer une nouvelle commande dans la base de données
        $commandeData = [
            'user_id' => $userId, // ID de l'utilisateur
            'status' => 'En attente de paiement', 
        ];
        $commandeId = $this->commandeModel->insert($commandeData);

        // Associer les produits du panier à la commande nouvellement créée
        foreach ($panier as $produit) {
            $produitData = [
                'commande_id' => $commandeId,
                'produit_id' => $produit['id'],
                'quantite' => $produit['quantite'],
                // Ajoutez d'autres données si nécessaire (comme le prix à l'époque de la commande)
            ];
            // Ajoutez le produit à la commande dans la base de données
            $this->commandeModel->ajouterProduit($produitData);
        }

        // Vider le panier après avoir passé la commande
        $this->session->remove('panier');

        // Retourner une réponse de succès avec l'ID de la commande créée
        return $this->respond(['message' => 'Commande créée avec succès', 'commande_id' => $commandeId]);
    }

    public function detailsCommande($idCommande) {
        // Récupérer les détails de la commande à partir de la base de données en utilisant le modèle CommandeModel
        $commandeDetails = $this->commandeModel->find($idCommande);
    
        // Vérifier si la commande existe
        if (!$commandeDetails) {
            return $this->fail('Commande non trouvée.');
        }
    
        // Retourner les détails de la commande en réponse JSON
        return $this->respond($commandeDetails);
    }

    public function historiqueCommandes() {
        // Récupérer l'ID de l'utilisateur actuellement connecté (si nécessaire)
        $userId = user_id();
    
        // Récupérer l'historique des commandes de l'utilisateur depuis la base de données en utilisant le modèle CommandeModel
        $historiqueCommandes = $this->commandeModel->where('user_id', $userId)->findAll();
    
        // Retourner l'historique des commandes en réponse JSON
        return $this->respond($historiqueCommandes);
    }
    
    public function listerMethodesPaiement() {
        // Récupérer les méthodes de paiement disponibles pour l'utilisateur depuis la base de données
        $methodesPaiement = []; // Récupérez les méthodes de paiement à partir de votre modèle de données
    
        // Retourner les méthodes de paiement en réponse JSON
        return $this->respond($methodesPaiement);
    }
    
}

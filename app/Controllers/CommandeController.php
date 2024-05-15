<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\CommandeModel;

class CommandeController extends BaseController
{
    use ResponseTrait;

    private $commandeModel;

    public function __construct()
    {
        $this->commandeModel = new CommandeModel();
    }

    public function search() {
        $keyword = $this->request->getGet('keyword');
        $results = $this->commandeModel->searchCommandes($keyword);
        return $this->respond($results);
    }

    public function index()
    {
        // Récupérer tous les commandes depuis la base de données
        $commandes = $this->commandeModel->findAll();

        // Vérifier s'il y a des commandes
        if (empty($commandes)) {
            // Aucune commande trouvée
            return $this->failNotFound('No commandes found');
        }

        // Retourner la liste des commandes
        return $this->respond($commandes);
    }

    public function create()
    {
        // Récupérer les données envoyées dans la requête
        $data = [
            'etat' => $this->request->getVar('etat'),
            'date' => $this->request->getVar('date'),
            'transaction' => $this->request->getVar('transaction'),
            'methode_pay' => $this->request->getVar('methode_pay'),
            'montant' => $this->request->getVar('montant'),
            'idProduit' => $this->request->getVar('idProduit'),
            'idUser' => $this->request->getVar('idUser'),
        ];

        // Insérer la nouvelle commande dans la base de données
        $this->commandeModel->insert($data);

        return $this->respond(['message' => 'Commande created successfully']);
    }

    // Méthode pour récupérer les commandes d'un utilisateur spécifique
    public function commandesUtilisateur($idUser)
    {
        // Récupérer les commandes de l'utilisateur depuis la base de données
        $commandesUtilisateur = $this->commandeModel->where('idUser', $idUser)->findAll();

        // Vérifier s'il y a des commandes pour cet utilisateur
        if (empty($commandesUtilisateur)) {
            // Aucune commande trouvée pour cet utilisateur
            return $this->failNotFound('No commandes found for this user');
        }

        // Retourner la liste des commandes de l'utilisateur
        return $this->respond($commandesUtilisateur);
    }

    public function validerCommande($id)
{
    $data = ['etat' => 'validated'];
    $this->commandeModel->update($id, $data);

    return $this->respond(['message' => 'Commande validée avec succès']);
}

}

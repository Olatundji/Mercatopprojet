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

        $results = $this->commandeModel->searchMarques($keyword);

        return $this->respond($results);
    }

    public function index()
    {
        // Récupérer tous les commande depuis la base de données
        $commandes = $this->commandeModel->findAll();

        // Vérifier s'il y a des commande
        if (empty($commandes)) {
            // Aucun commande trouvé
            return $this->failNotFound('No commande found');
        }

        // Retourner la liste des produits
        return $this->respond($commandes);
    }

    public function create()
    {
        // Récupérer les données envoyées dans la requête
        $data = [
            'etat' => $this->request->getPost('etat'),
            'date' => $this->request->getPost('date'),
            'transaction' => $this->request->getPost('transaction'),
            'methode_pay' => $this->request->getPost('methode_pay'),
            'montant' => $this->request->getPost('montant'),
            'idProduit' => $this->request->getPost('idProduit'),
            'idUser' => $this->request->getPost('idUser'),

        ];

        // Insérer le nouveau produit dans la base de données
        $this->commandeModel->insert($data);

        return $this->respond(['message' => 'commande created successfully']);
    }

    
}

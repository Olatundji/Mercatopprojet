<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\CategorieModel;

class CategorieController extends BaseController
{
    use ResponseTrait;

    private $categorieModel;

    public function __construct()
    {
        $this->categorieModel = new CategorieModel();
    }

    public function search() {
        $keyword = $this->request->getGet('keyword');

        $results = $this->categorieModel->searchcategories($keyword);

        return $this->respond($results);
    }

    public function index()
    {
        // Récupérer tous les produits depuis la base de données
        $categories = $this->categorieModel->findAll();

        // Vérifier s'il y a des produits
        if (empty($categories)) {
            // Aucun produit trouvé
            return $this->failNotFound('No categorie found');
        }

        // Retourner la liste des produits
        return $this->respond(['categories' => $categories]);
    }

    public function create()
    {
        // Récupérer les données envoyées dans la requête
        $data = [
            'libelle' => $this->request->getVar('libelle')
        ];

        // Insérer le nouveau produit dans la base de données
        $this->categorieModel->insert($data);

        return $this->respond(['message' => 'categorie created successfully']);
    }

    public function update($id)
    {
        // Récupérer les données envoyées dans la requête
        $data = [
            'nom' => $this->request->getVar('nom'),
        ];

        // Mettre à jour le produit dans la base de données
        $this->categorieModel->update($id, $data);

        return $this->respond(['message' => 'categorie updated successfully']);
    }

    public function delete($id)
    {
        // Supprimer le produit de la base de données
        $this->categorieModel->delete($id);

        return $this->respondDeleted(['message' => 'categorie deleted successfully']);
    }
}

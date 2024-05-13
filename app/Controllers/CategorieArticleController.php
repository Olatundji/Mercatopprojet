<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\CategorieArticleModel;

class CategorieArticleController extends BaseController
{
    use ResponseTrait;

    private $categorieArticleModel;

    public function __construct()
    {
        $this->categorieArticleModel = new CategorieArticleModel();
    }

    public function search() {
        $keyword = $this->request->getGet('keyword');

        $results = $this->categorieArticleModel->searchcategories($keyword);

        return $this->respond($results);
    }

    public function index()
    {
        // Récupérer tous les produits depuis la base de données
        $categories = $this->categorieArticleModel->findAll();

        // Vérifier s'il y a des produits
        if (empty($categorieArticles)) {
            // Aucun produit trouvé
            return $this->failNotFound('No categorie found');
        }

        // Retourner la liste des produits
        return $this->respond($categorieArticles);
    }

    public function create()
    {
        // Récupérer les données envoyées dans la requête
        $data = [
            'libelle' => $this->request->getPost('libelle')

        ];

        // Insérer le nouveau produit dans la base de données
        $this->categorieArticleModel->insert($data);

        return $this->respond(['message' => 'categorie created successfully']);
    }

    public function update($id)
    {
        // Récupérer les données envoyées dans la requête
        $data = [
            'libelle' => $this->request->getPost('libelle'),
        ];

        // Mettre à jour le produit dans la base de données
        $this->categorieArticleModel->update($id, $data);

        return $this->respond(['message' => 'categorie updated successfully']);
    }

    public function delete($id)
    {
        // Supprimer le produit de la base de données
        $this->categorieArticleModel->delete($id);

        return $this->respondDeleted(['message' => 'categorie deleted successfully']);
    }
}

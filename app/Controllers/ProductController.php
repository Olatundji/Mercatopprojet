<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\ProductModel;

class ProductController extends BaseController
{
    use ResponseTrait;

    private $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function search() {
        $keyword = $this->request->getGet('keyword');

        $results = $this->productModel->searchProducts($keyword);

        return $this->respond($results);
    }

    public function index()
    {
        // Récupérer tous les produits depuis la base de données
        $products = $this->productModel->findAll();

        // Vérifier s'il y a des produits
        if (empty($products)) {
            // Aucun produit trouvé
            return $this->failNotFound('No products found');
        }

        // Retourner la liste des produits
        return $this->respond($products);
    }

    public function create()
    {
        // Récupérer les données envoyées dans la requête
        $data = [
            'nom' => $this->request->getPost('nom'),
            'prix' => $this->request->getPost('prix'),
            'description' => $this->request->getPost('description'),
            'image' => $this->request->getPost('image'),
            'qte' => $this->request->getPost('qte'),
            'idMarque' => $this->request->getPost('idMarque'),
            'idCategorie' => $this->request->getPost('idCategorie'),

        ];

        // Insérer le nouveau produit dans la base de données
        $this->productModel->insert($data);

        return $this->respondCreated(['message' => 'Product created successfully']);
    }

    public function update($id)
    {
        // Récupérer les données envoyées dans la requête
        $data = [
            'nom' => $this->request->getPost('nom'),
            'prix' => $this->request->getPost('prix'),
            'description' => $this->request->getPost('description'),
            'image' => $this->request->getPost('image'),
            'qte' => $this->request->getPost('qte'),
            'idMarque' => $this->request->getPost('idMarque'),
            'idCategorie' => $this->request->getPost('idCategorie'),
        ];

        // Mettre à jour le produit dans la base de données
        $this->productModel->update($id, $data);

        return $this->respond(['message' => 'Product updated successfully']);
    }

    public function delete($id)
    {
        // Supprimer le produit de la base de données
        $this->productModel->delete($id);

        return $this->respondDeleted(['message' => 'Product deleted successfully']);
    }
    public function rechercheParCategorie($idCategorie) {
        // Récupérer les produits de la catégorie spécifiée depuis la base de données
        $products = $this->productModel->where('idCategorie', $idCategorie)->findAll();
    
        // Vérifier s'il y a des produits dans la catégorie spécifiée
        if (empty($products)) {
            // Aucun produit trouvé dans la catégorie spécifiée
            return $this->failNotFound('No products found in this category');
        }
    
        // Retourner la liste des produits de la catégorie spécifiée
        return $this->respond($products);
    }
}

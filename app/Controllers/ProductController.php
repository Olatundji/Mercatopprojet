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

        $results = $this->productModel->searchProduit($keyword);

        return $this->respond($results);
    }

    public function index()
{
    // Récupérer la page actuelle à partir de la requête GET
    $page = $this->request->getVar('page') ?? 1;

    // Définir le nombre d'éléments par page
    $perPage = 10;

    // Récupérer tous les produits depuis la base de données avec les détails de la marque et de la catégorie
    $produit = $this->productModel
                    ->select('produit.*, marques.nom as marque_nom, categories.libelle as categorie_nom')
                    ->join('marques', 'marques.id = produit.idMarque')
                    ->join('categories', 'categories.id = produit.idCategorie')
                    ->paginate($perPage, 'default', $page);

    // Vérifier s'il y a des produits
    if (empty($produit)) {
        // Aucun produit trouvé
        return $this->respond(['message' => 'No products found'], 404);
    }

    // Formatter la réponse avec les détails de la marque et de la catégorie
    $formattedProduit = [];
    foreach ($produit as $product) {
        $formattedProduit[] = [
            'id' => $product['id'],
            'nom' => $product['nom'],
            'prix' => $product['prix'],
            'description' => $product['description'],
            'qte' => $product['qte'],
            'marque' => [
                'id' => $product['idMarque'],
                'nom' => $product['marque_nom']
            ],
            'categorie' => [
                'id' => $product['idCategorie'],
                'nom' => $product['categorie_nom']
            ]
        ];
    }

    // Retourner la liste des produits formatés avec les détails de la marque et de la catégorie
    return $this->respond($formattedProduit);
}



    public function create()
    {
        // Récupérer les données envoyées dans la requête
        $data = [
            'nom' => $this->request->getPost('nom'),
            'prix' => $this->request->getPost('prix'),
            'description' => $this->request->getPost('description'),
            'qte' => $this->request->getPost('qte'),
            'idMarque' => $this->request->getPost('idMarque'),
            'idCategorie' => $this->request->getPost('idCategorie'),

        ];

        // Insérer le nouveau produit dans la base de données
        $this->productModel->insert($data);

        return $this->respond(['message' => 'Product created successfully']);
    }

    public function update($id)
    {
        // Récupérer les données envoyées dans la requête
        $data = [
            'nom' => $this->request->getPost('nom'),
            'prix' => $this->request->getPost('prix'),
            'description' => $this->request->getPost('description'),
            //'image' => $this->request->getPost('image'),
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
        $produit = $this->productModel->where('idCategorie', $idCategorie)->findAll();
    
        // Vérifier s'il y a des produits dans la catégorie spécifiée
        if (empty($produit)) {
            // Aucun produit trouvé dans la catégorie spécifiée
            return $this->failNotFound('No products found in this category');
        }
    
        // Retourner la liste des produits de la catégorie spécifiée
        return $this->respond($produit);
    }
}

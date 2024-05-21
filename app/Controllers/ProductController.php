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
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 10;
        $produit = $this->productModel
                        ->select('produit.*, marques.nom as marque_nom, categories.libelle as categorie_nom')
                        ->join('marques', 'marques.id = produit.idMarque')
                        ->join('categories', 'categories.id = produit.idCategorie')
                        ->paginate($perPage, 'default', $page);

        if (empty($produit)) {
            return $this->respond(['message' => 'No products found'], 404);
        }

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

        return $this->respond($formattedProduit);
    }

    public function create()
    {
        if (!$this->validate($this->productModel->validationRules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $file = $this->request->getFile('image');
        $data = $this->request->getPost();

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $filePath = 'uploads/' . $fileName;
            $file->move('uploads', $fileName);

            $baseURL = config('App')->baseURL;
            $fullPath = $baseURL . $filePath;

            $data['image'] = $fullPath;
        }

        $this->productModel->insert($data);

        return $this->respond(['message' => 'Product created successfully', 'data' => $data]);
    }

    public function update($id)
    {
        $file = $this->request->getFile('image');
        $data = $this->request->getPost();

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $filePath = 'uploads/' . $fileName;
            $file->move('uploads', $fileName);

            $baseURL = config('App')->baseURL;
            $fullPath = $baseURL . $filePath;

            $data['image'] = $fullPath;
        }

        $this->productModel->update($id, $data);

        return $this->respond(['message' => 'Product updated successfully']);
    }

    public function delete($id)
    {
        $this->productModel->delete($id);
        return $this->respondDeleted(['message' => 'Product deleted successfully']);
    }

    public function rechercheParCategorie($idCategorie) {
        $produit = $this->productModel->where('idCategorie', $idCategorie)->findAll();

        if (empty($produit)) {
            return $this->failNotFound('No products found in this category');
        }

        return $this->respond($produit);
    }
}

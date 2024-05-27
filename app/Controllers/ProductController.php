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

    public function search()
    {
        $keyword = $this->request->getGet('keyword');
        $results = $this->productModel->searchProduit($keyword);
        return $this->respond($results);
    }

    public function index()
    {
        $page = $this->request->getVar('page') ?? 1;
        $limit = $this->request->getVar('limit') ?? 10;
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

        return $this->respond(['produits' => $formattedProduit]);
    }

    public function detail($id)
    {
        // Récupérer le produit par son ID
        $product = $this->productModel
            ->select('produit.*, marques.nom as marque_nom, categories.libelle as categorie_nom')
            ->join('marques', 'marques.id = produit.idMarque')
            ->join('categories', 'categories.id = produit.idCategorie')
            ->find($id);

        if (!$product) {
            return $this->failNotFound('Product not found');
        }

        // Formater les données du produit
        $formattedProduct = [
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
            ],
            'image' => $product['image']
        ];

        return $this->respond($formattedProduct);
    }

    public function create()
    {
        $validation = \Config\Services::validation();
        $validation->setRules($this->productModel->validationRules);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->failValidationErrors($validation->getErrors());
        }

        $file = $this->request->getFile('image');
        $data = [
            'nom' => $this->request->getVar('nom'),
            'prix' => $this->request->getVar('prix'),
            'description' => $this->request->getVar('description'),
            'qte' => $this->request->getVar('qte'),
            'idMarque' => $this->request->getVar('idMarque'),
            'idCategorie' => $this->request->getVar('idCategorie')
        ];

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $filePath = 'uploads/' . $fileName;
            $file->move(WRITEPATH . 'uploads', $fileName);

            $data['image'] = base_url('uploads/' . $fileName);
        }

        log_message('info', 'Data to be inserted: ' . json_encode($data));

        if (!$this->productModel->insert($data)) {
            log_message('error', 'Failed to insert product: ' . json_encode($this->productModel->errors()));
            return $this->failServerError('Failed to create product');
        }

        return $this->respondCreated(['message' => 'Product created successfully', 'data' => $data]);
    }

    public function update($id)
    {
        $validation = \Config\Services::validation();
        $validation->setRules($this->productModel->validationRules);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->failValidationErrors($validation->getErrors());
        }

        $file = $this->request->getFile('image');
        $data = [
            'nom' => $this->request->getVar('nom'),
            'prix' => $this->request->getVar('prix'),
            'description' => $this->request->getVar('description'),
            'qte' => $this->request->getVar('qte'),
            'idMarque' => $this->request->getVar('idMarque'),
            'idCategorie' => $this->request->getVar('idCategorie')
        ];

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $filePath = 'uploads/' . $fileName;
            $file->move(WRITEPATH . 'uploads', $fileName);

            $data['image'] = base_url('uploads/' . $fileName);
        }

        log_message('info', 'Data to be updated for ID ' . $id . ': ' . json_encode($data));

        if (!$this->productModel->update($id, $data)) {
            log_message('error', 'Failed to update product: ' . json_encode($this->productModel->errors()));
            return $this->failServerError('Failed to update product');
        }

        return $this->respond(['message' => 'Product updated successfully']);
    }

    public function delete($id)
    {
        $this->productModel->delete($id);
        return $this->respondDeleted(['message' => 'Product deleted successfully']);
    }

    public function rechercheParCategorie($idCategorie)
    {
        $produit = $this->productModel->where('idCategorie', $idCategorie)->findAll();

        if (empty($produit)) {
            return $this->failNotFound('No products found in this category');
        }

        return $this->respond($produit);
    }

    public function getRandomProduit()
    {
        try {
            log_message('info', 'Entering getRandomProducts method');

            $produit = $this->productModel->getRandomProduit(4);

            if (empty($produit)) {
                log_message('info', 'No products found');
            } else {
                log_message('info', 'Products found: ' . json_encode($produit));
            }

            return $this->respond($produit, 200);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return $this->fail('An error occurred: ' . $e->getMessage(), 500);
        }
    }
}

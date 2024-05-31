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


    public function show($id)
    {
        $product = $this->productModel
            ->select('produit.*, marques.nom as marque_nom, categories.libelle as categorie_nom')
            ->join('marques', 'marques.id = produit.idMarque')
            ->join('categories', 'categories.id = produit.idCategorie')
            ->find($id);

        if (!$product) {
            return $this->failNotFound('Product not found');
        }

        $commentaires = $this->productModel->getProductCommentaires($id);

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
            'image' => $product['image'],
            'commentaires' => $commentaires // Ajouter les commentaires comme attribut du produit
        ];

        return $this->respond($formattedProduct);
    }


    public function search()
    {
        $keyword = $this->request->getGet('keyword');

        if (is_null($keyword) || trim($keyword) === '') {
            return $this->fail('Keyword cannot be null or empty', 400);
        }

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
            ->paginate($limit, 'default', $page);

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
            $file->move(FCPATH . 'uploads', $fileName);

            // Construire le chemin d'accès complet à l'image
            $data['image'] = base_url('uploads/' . $fileName);
        }

        if (!$this->productModel->insert($data)) {
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
            $file->move(FCPATH . 'uploads', $fileName);

            // Construire le chemin d'accès public à l'image
            $data['image'] = base_url('uploads/' . $fileName);
        }

        if (!$this->productModel->update($id, $data)) {
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
        $limit = $this->request->getVar('limit') ?? 10;
        try {
            log_message('info', 'Entering getRandomProducts method');

            $produits = $this->productModel
                ->select('produit.*, marques.nom as marque_nom, categories.libelle as categorie_nom')
                ->join('marques', 'marques.id = produit.idMarque')
                ->join('categories', 'categories.id = produit.idCategorie')
                ->findAll($limit);

            if (empty($produits)) {
                return $this->failNotFound('No products found');
            }

            $formattedProduits = [];
            foreach ($produits as $produit) {
                $formattedProduits[] = [
                    'id' => $produit['id'],
                    'nom' => $produit['nom'],
                    'prix' => $produit['prix'],
                    'description' => $produit['description'],
                    'qte' => $produit['qte'],
                    'marque' => [
                        'id' => $produit['idMarque'],
                        'nom' => $produit['marque_nom']
                    ],
                    'categorie' => [
                        'id' => $produit['idCategorie'],
                        'nom' => $produit['categorie_nom']
                    ],
                    'image' => $produit['image']
                ];
            }

            log_message('info', 'Found products: ' . json_encode($formattedProduits));
            return $this->respond($formattedProduits, 200);
        } catch (\Exception $e) {
            log_message('error', 'An error occurred: ' . $e->getMessage());
            return $this->failServerError('An error occurred: ' . $e->getMessage());
        }
    }

    public function searchFilters()
    {
        // Récupérer les paramètres de filtre de la requête
        $categorieId = $this->request->getVar('idCategorie');
        $marqueId = $this->request->getVar('idMarque');
        $prix_min = $this->request->getVar('prix_min');
        $prix_max = $this->request->getVar('prix_max');
        // $nom = $this->request->getVar('nom');

        // Construire la requête de recherche avec les filtres
        $query = $this->productModel
            ->select('produit.*, marques.nom as marque_nom, categories.libelle as categorie_nom')
            ->join('marques', 'marques.id = produit.idMarque')
            ->join('categories', 'categories.id = produit.idCategorie');

        // Ajouter les conditions de filtre à la requête
        if ($categorieId !== null) {
            $query->where('produit.idCategorie=', $categorieId);
        }

        if ($marqueId !== null) {
            $query->where('produit.idMarque=', $marqueId);
        }

        // if ($nom !== null) {
        //     $query->like('produit.nom=', $nom);
        // }

        if ($prix_min !== null) {
            $query->where('produit.prix >=', $prix_min);
        }

        if ($prix_max !== null) {
            $query->where('produit.prix <=', $prix_max);
        }

        // Exécuter la requête et obtenir les résultats
        $produit = $query->findAll();

        // Formater les produits pour la réponse
        $formattedProduit = [];
        foreach ($produit as $produit) {
            $formattedProduit[] = [
                'id' => $produit['id'],
                'nom' => $produit['nom'],
                'prix' => $produit['prix'],
                'description' => $produit['description'],
                'qte' => $produit['qte'],
                'marque' => [
                    'id' => $produit['idMarque'],
                    'nom' => $produit['marque_nom']
                ],
                'categorie' => [
                    'id' => $produit['idCategorie'],
                    'nom' => $produit['categorie_nom']
                ],
                'image' => $produit['image']
            ];
        }

        // Renvoyer la réponse avec les produits formatés
        return $this->respond($formattedProduit);
    }
}

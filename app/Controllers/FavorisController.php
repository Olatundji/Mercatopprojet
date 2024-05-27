<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\FavorisModel;

class FavorisController extends BaseController
{
    use ResponseTrait;

    private $favorisModel;

    public function __construct()
    {
        $this->favorisModel = new FavorisModel();
    }

    public function index($idUser)
    {
        $page = $this->request->getVar('page') ?? 1;

        $perPage = 10;

        $favoris = $this->favorisModel
            ->select('favoris.*, produit.*, categories.libelle as categorie_nom, marques.nom as marque_nom')
            ->join('produit', 'produit.id = favoris.idProduit')
            ->join('categories', 'categories.id = produit.idCategorie')
            ->join('marques', 'marques.id = produit.idMarque')
            ->where('favoris.idUser', $idUser)
            ->paginate($perPage, 'default', $page);

        if (empty($favoris)) {
            return $this->respond(['message' => 'No favoris found for this user'], 404);
        }

        $formattedFavoris = [];
        foreach ($favoris as $favori) {
            $formattedFavoris[] = [
                'id' => $favori['id'],
                'produit' => [
                    'id' => $favori['idProduit'],
                    'nom' => $favori['nom'],
                    'description' => $favori['description'],
                    'image' => $favori['image'],
                    'qte' => $favori['qte'],
                    'idCategorie' => $favori['idCategorie'],
                    'categorie_nom' => $favori['categorie_nom'],
                    'idMarque' => $favori['idMarque'],
                    'marque_nom' => $favori['marque_nom']
                ]
            ];
        }

        return $this->respond($formattedFavoris);
    }

    public function create()
    {
        if (!$this->validate($this->favorisModel->validationRules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $data = [
            'idProduit' => $this->request->getVar('idProduit'),
            'idUser' => $this->request->getVar('idUser'),
        ];

        $this->favorisModel->insert($data);

        return $this->respond(['message' => 'Favoris created successfully']);
    }

    public function delete($id)
    {
        log_message('info', 'Trying to delete favoris with id: ' . $id);

        $favori = $this->favorisModel->find($id);
        if (!$favori) {
            log_message('error', 'Favoris not found with id: ' . $id);
            return $this->failNotFound('Favoris not found');
        }

        if ($this->favorisModel->delete($id)) {
            log_message('info', 'Favoris deleted successfully with id: ' . $id);
            return $this->respondDeleted(['message' => 'Favoris deleted successfully']);
        } else {
            log_message('error', 'Failed to delete favoris with id: ' . $id);
            return $this->fail('Failed to delete favoris');
        }
    }
}

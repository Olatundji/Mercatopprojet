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
            ->select('favoris.*, produit.nom as produit_nom')
            ->join('produit', 'produit.id = favoris.idProduit')
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
                    'nom' => $favori['produit_nom']
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

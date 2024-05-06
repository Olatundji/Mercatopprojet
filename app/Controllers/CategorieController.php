<?php

namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;
use App\Models\CategorieModel;

class Categories extends \CodeIgniter\Controller
{
    use ResponseTrait;

    public function index()
    {
        // Récupère toutes les marques
        $model = new CategorieModel();
        $marques = $model->findAll();

        return $this->respond($marques);
    }

    public function create()
    {
        $data = [
            'nom' => $this->request->getPost('nom'),
        ];
        
        // Insérer la marque dans la base de données
        $model = new CategorieModel();
        $model->insert($data);
        
        return $this->respondCreated(['message' => 'Categorie created successfully']);
    }

    public function update($id = null)
    {
        $data = [
            'libelle' => $this->request->getPost('libelle'),
        ];

        // Mettre à jour la marque dans la base de données
        $model = new CategorieModel();
        $model->update($id, $data);
        
        return $this->respond(['message' => 'Categorie updated successfully']);
    }

    public function delete($id = null)
    {
        // Supprime une marque
        $model = new CategorieModel();

        if ($model->delete($id)) {
            return $this->respondDeleted(['id' => $id]);
        }

        return $this->failNotFound('ID non trouvé : ' . $id);
    }
}

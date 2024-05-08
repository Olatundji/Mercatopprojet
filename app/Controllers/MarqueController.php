<?php

namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;
use App\Models\MarqueModel;

class Marques extends \CodeIgniter\Controller
{
    use ResponseTrait;

    

    public function index()
    {
        // Récupère toutes les marques
        $model = new MarqueModel();
        $marques = $model->findAll();

        return $this->respond($marques);
    }
    

    public function create()
    {
        $data = [
            'nom' => $this->request->getPost('nom'),
        ];
        
        // Insérer la marque dans la base de données
        $model = new MarqueModel();
        $model->insert($data);
        
        return $this->respondCreated(['message' => 'Marque created successfully']);
    }

    public function update($id = null)
    {
        $data = [
            'nom' => $this->request->getPost('nom'),
        ];

        // Mettre à jour la marque dans la base de données
        $model = new MarqueModel();
        $model->update($id, $data);
        
        return $this->respond(['message' => 'Marque updated successfully']);
    }

    public function delete($id = null)
    {
        // Supprime une marque
        $model = new MarqueModel();

        if ($model->delete($id)) {
            return $this->respondDeleted(['id' => $id]);
        }

        return $this->failNotFound('ID non trouvé : ' . $id);
    }
}

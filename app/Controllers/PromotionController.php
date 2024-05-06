<?php

namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;
use App\Models\PromotionModel;

class PromotionController extends \CodeIgniter\Controller
{
    use ResponseTrait;

    protected $promotionModel;

    public function __construct()
    {
        $this->promotionModel = new PromotionModel();
    }

    // Afficher la liste des promotions
    public function index()
    {
        $promotions = $this->promotionModel->findAll();
        return $this->respond($promotions);
    }

    // Afficher une promotion spécifique
    public function show($id = null)
    {
        $promotion = $this->promotionModel->find($id);
        if (!$promotion) {
            return $this->failNotFound('Promotion not found');
        }
        return $this->respond($promotion);
    }

    // Créer une nouvelle promotion
    public function create()
    {
        $data = [
            'code' => $this->request->getPost('code'),
            'reduction' => $this->request->getPost('reduction'),
            'date_debut' => $this->request->getPost('date_debut'),
            'date_fin' => $this->request->getPost('date_fin'),
            'idProduit' => $this->request->getPost('idProduit'),

        ];
        
        // Insérer la promotion dans la base de données
        $this->promotionModel->insert($data);
        
        return $this->respondCreated(['message' => 'Promotion created successfully']);
    }

    // Mettre à jour une promotion existante
    public function update($id = null)
    {
        $data = [
            'code' => $this->request->getPost('code'),
            'reduction' => $this->request->getPost('reduction'),
            'date_debut' => $this->request->getPost('date_debut'),
            'date_fin' => $this->request->getPost('date_fin'),
            'idProduit' => $this->request->getPost('idProduit'),

        ];
        // Mettre à jour la promotion dans la base de données
        $this->promotionModel->update($id, $data);
        
        return $this->respond(['message' => 'Promotion updated successfully']);
    }

    // Supprimer une promotion
    public function delete($id = null)
    {
        // Vérifier si la promotion existe
        $promotion = $this->promotionModel->find($id);
        if (!$promotion) {
            return $this->failNotFound('Promotion not found');
        }
        
        // Supprimer la promotion de la base de données
        $this->promotionModel->delete($id);
        
        return $this->respondDeleted(['message' => 'Promotion deleted successfully']);
    }
}

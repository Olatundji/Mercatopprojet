<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\MarqueModel;

class MarqueController extends BaseController
{
    use ResponseTrait;

    private $marqueModel;

    public function __construct()
    {
        $this->marqueModel = new MarqueModel();
    }

    public function search() {
        $keyword = $this->request->getGet('keyword');

        $results = $this->marqueModel->searchMarques($keyword);

        return $this->respond($results);
    }

    public function index()
    {
        // Récupérer tous les produits depuis la base de données
        $marques = $this->marqueModel->findAll();

        // Vérifier s'il y a des produits
        if (empty($marques)) {
            // Aucun produit trouvé
            return $this->failNotFound('No Marques found');
        }

        // Retourner la liste des produits
        return $this->respond($marques);
    }

    public function create()
    {
        if (!$this->validate($this->marqueModel->validationRules)) {
            // Si la validation échoue, renvoyer les erreurs de validation
            return $this->failValidationErrors($this->validator->getErrors());
        }
        // Récupérer les données envoyées dans la requête
        $data = [
            'nom' => $this->request->getPost('nom')

        ];

        // Insérer le nouveau produit dans la base de données
        $this->marqueModel->insert($data);

        return $this->respond(['message' => 'Marque created successfully']);
    }

    public function update($id)
    {
        // Récupérer les données envoyées dans la requête
        $data = [
            'nom' => $this->request->getPost('nom'),
        ];

        // Mettre à jour le produit dans la base de données
        $this->marqueModel->update($id, $data);

        return $this->respond(['message' => 'Marque updated successfully']);
    }

    public function delete($id)
    {
        // Supprimer le produit de la base de données
        $this->marqueModel->delete($id);

        return $this->respondDeleted(['message' => 'Marque deleted successfully']);
    }
}

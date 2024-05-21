<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\ParametreModel;

class ParametreController extends BaseController
{
    use ResponseTrait;

    private $parametreModel;

    public function __construct()
    {
        $this->parametreModel = new ParametreModel();
    }

    public function index()
    {
        // Récupérer tous les produits depuis la base de données
        $parametres = $this->parametreModel->findAll();

        // Vérifier s'il y a des produits
        if (empty($parametres)) {
            // Aucun produit trouvé
            return $this->failNotFound('No Marques found');
        }

        // Retourner la liste des produits
        return $this->respond($parametres);
    }

    public function create()
    {
        if (!$this->validate($this->parametreModel->validationRules)) {
            // Si la validation échoue, renvoyer les erreurs de validation
            return $this->failValidationErrors($this->validator->getErrors());
        }
        // Récupérer les données envoyées dans la requête
        $data = [
            'nom' => $this->request->getVar('nom'),
            'logo' => $this->request->getVar('logo'),
            'slogan' => $this->request->getVar('slogan'),
            'address' => $this->request->getVar('address'),
        ];

        // Insérer le nouveau produit dans la base de données
        $this->parametreModel->insert($data);

        return $this->respond(['message' => 'parametre created successfully']);
    }

    public function update($id)
    {
        // Récupérer les données envoyées dans la requête
        $data = [
            'name' => $this->request->getVar('nom'),
            'logo' => $this->request->getVar('logo'),
            'slogan' => $this->request->getVar('slogan'),
            'address' => $this->request->getVar('address'),
        ];

        // Mettre à jour le produit dans la base de données
        $this->parametreModel->update($id, $data);

        return $this->respond(['message' => 'parametre updated successfully']);
    }
}




<?php

namespace App\Controllers;

use App\Models\ParametreModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;

class ParametreController extends ResourceController
{

    protected $parametreModel;

    public function __construct()
    {
        $this->parametreModel = new ParametreModel();
        helper(['form', 'url']);
    }
    public function show($id = 1)
    {
        if ($id === null) {
            return $this->fail('ID is required for show operation', ResponseInterface::HTTP_BAD_REQUEST);
        }

        $parametre = $this->parametreModel->find($id);

        if ($parametre === null) {
            return $this->fail('Parameter not found', ResponseInterface::HTTP_NOT_FOUND);
        }

        return $this->respond($parametre);
    }

    public function update($id = null)
    {
        log_message('info', 'Starting update method');

        // Vérifier s'il y a un fichier téléchargé
        $file = $this->request->getFile('logo');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            log_message('info', 'File is valid and ready to be uploaded');

            // Définir le chemin de téléchargement
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads', $newName);

            // Récupérer le chemin complet de l'image téléchargée
            $logo_path = base_url('uploads/' . $newName);
        } else {
            log_message('error', 'File upload error: ' . ($file ? $file->getErrorString() : 'File not found'));

            // Gérer les erreurs de téléchargement
            $response = [
                'status' => 'error',
                'message' => $file ? $file->getErrorString() : 'File not found'
            ];
            return $this->respond($response, ResponseInterface::HTTP_BAD_REQUEST);
        }

        // Récupérer les données du formulaire
        $data = [
            'nom' => $this->request->getPost('nom'),
            'slogan' => $this->request->getPost('slogan'),
            'adresse' => $this->request->getPost('adresse'),
            'logo' => $logo_path
        ];

        log_message('info', 'Form data received: ' . json_encode($data));

        // Mettre à jour le paramètre dans la base de données
        if ($this->parametreModel->update($id, $data)) {
            log_message('info', 'Parameter updated successfully');

            $response = [
                'status' => 'success',
                'message' => 'Parameter updated successfully'
            ];
        } else {
            log_message('error', 'Database update failed: ' . json_encode($this->parametreModel->errors()));

            $response = [
                'status' => 'error',
                'message' => 'Failed to update parameter',
                'errors' => $this->parametreModel->errors()
            ];
        }

        return $this->respond($response);
    }
}

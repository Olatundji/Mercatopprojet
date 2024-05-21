<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UploadModel;

class FileController extends ResourceController {

    public function uploadFile() {
        if (!is_dir(ROOTPATH . 'uploads')) {
            mkdir(ROOTPATH . 'uploads', 0755, true);
        }

        $file = $this->request->getFile('file');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'uploads', $newName);

            // Enregistrer les informations du fichier dans la base de données
            $uploadModel = new UploadModel();
            $uploadData = [
                'file_name' => $newName,
                'original_name' => $file->getClientName(),
                'file_type' => $file->getClientMimeType(),
                'file_size' => $file->getSize(),
                'file_path' => 'uploads/' . $newName, // Adjusted path for portability
            ];
            $uploadModel->insert($uploadData);

            return $this->respondCreated([
                'status' => 'success',
                'message' => 'File uploaded successfully',
                'file_name' => $newName
            ]);
        } else {
            if (!$file) {
                $errorMessage = 'No file was uploaded';
            } elseif (!$file->isValid()) {
                $errorMessage = 'File is not valid';
            } elseif ($file->hasMoved()) {
                $errorMessage = 'File has already been moved';
            } else {
                $errorMessage = 'Unknown error';
            }

            return $this->failValidationError('Failed to upload file: ' . $errorMessage);
        }
    }
}

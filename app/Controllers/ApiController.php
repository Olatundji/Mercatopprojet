<?php

namespace App\Controllers;
defined('BASEPATH') OR exit('No direct script access allowed');

class ApiController extends BaseController {

    public function uploadFile() {
        if ($_FILES && isset($_FILES['userfile'])) {
            $file = $_FILES['userfile'];
    
            if ($file['error'] === UPLOAD_ERR_OK) {
                $uploadPath = './uploads/';
                $fileName = $file['name'];
                move_uploaded_file($file['tmp_name'], $uploadPath . $fileName);
    
                $response = array('status' => 'success', 'message' => 'File uploaded successfully', 'file_name' => $fileName);
            } else {
                // Répondre avec un message d'erreur
                $response = array('status' => 'error', 'message' => 'Failed to upload file');
            }
        } else {
            // Répondre avec un message d'erreur si aucun fichier n'a été envoyé
            $response = array('status' => 'error', 'message' => 'No file uploaded');
        }
    
        // Envoyer la réponse au client 
        echo json_encode($response);
    }
    
}

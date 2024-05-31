<?php

namespace App\Controllers;

use App\Models\ProduitCommentaireModel;
use App\Models\ArticleCommentaireModel;
use CodeIgniter\RESTful\ResourceController;

class CommentaireController extends ResourceController
{
    public function createProduitCommentaire()
    {

        $model = new ProduitCommentaireModel();

        $data = [
            'contenu' => $this->request->getVar('contenu'),
            'idUser' => $this->request->getVar('idUser'),
            'idProduit' => $this->request->getVar('idProduit'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if ($model->insert($data)) {
            return $this->respondCreated(['status' => 'success', 'message' => 'Commentaire produit créé avec succès']);
        } else {
            return $this->failValidationErrors($model->errors());
        }
    }

    public function createArticleCommentaire()
    {
        $model = new ArticleCommentaireModel();

        $data = [
            'contenu' => $this->request->getVar('contenu'),
            'idUser' => $this->request->getVar('idUser'),
            'idArticle' => $this->request->getVar('idArticle'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if ($model->insert($data)) {
            return $this->respondCreated(['status' => 'success', 'message' => 'Commentaire article créé avec succès']);
        } else {
            return $this->failValidationErrors($model->errors());
        }
    }
}

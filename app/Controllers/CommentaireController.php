<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\CommentaireModel;

class CommentaireController extends BaseController
{
    use ResponseTrait;

    private $commentaireModel;

    public function __construct()
    {
        $this->commentaireModel = new CommentaireModel();
    }

    public function search()
    {
        $keyword = $this->request->getGet('keyword');

        $results = $this->commentaireModel->searchCommentaires($keyword);

        return $this->respond($results);
    }

    public function index()
    {
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 10;
        $type = $this->request->getVar('type');

        $commentaireQuery = $this->commentaireModel
            ->select('commentaires.contenu, users.nom as user_nom');

        if ($type === 'produit') {
            $commentaireQuery->join('produit', 'produit.id = commentaires.idProduit')
                ->join('users', 'users.id = commentaires.idUser')
                ->where('commentaires.idArticle', null);
        } elseif ($type === 'article') {
            $commentaireQuery->join('articles', 'articles.id = commentaires.idArticle')
                ->join('users', 'users.id = commentaires.idUser')
                ->where('commentaires.idProduit', null);
        } else {
            return $this->respond(['message' => 'Invalid type specified. Use "produit" or "article".'], 400);
        }

        $commentaires = $commentaireQuery->paginate($perPage, 'default', $page);

        if (empty($commentaires)) {
            return $this->respond(['message' => 'No commentaire found'], 404);
        }

        $formattedCommentaires = [];
        foreach ($commentaires as $commentaire) {
            $formattedCommentaires[] = [
                'contenu' => $commentaire['contenu'],
                'user' => [
                    'nom' => $commentaire['user_nom']
                ]
            ];
        }

        return $this->respond($formattedCommentaires);
    }






    public function create()
    {
        $idProduit = $this->request->getVar('idProduit');
        $idArticle = $this->request->getVar('idArticle');

        // Vérifie que seulement l'un des deux est spécifié
        if (($idProduit && $idArticle) || (!$idProduit && !$idArticle)) {
            return $this->fail('A comment must be linked to either a product or an article, but not both.');
        }

        $data = [
            'contenu' => $this->request->getVar('contenu'),
            'idProduit' => $idProduit,
            'idArticle' => $idArticle,
            'idUser' => $this->request->getVar('idUser'),
        ];

        $this->commentaireModel->insert($data);

        return $this->respond(['message' => 'Commentaire created successfully']);
    }
}

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
            ->select('commentaires.*, produit.nom as produit_nom, articles.contenu as article_nom , users.nom as user_nom')
            ->join('users', 'users.id = commentaires.idUser');

        if ($type === 'produit') {
            $commentaireQuery->join('produit', 'produit.id = commentaires.idProduit')
                ->where('commentaires.idArticle', null);
        } elseif ($type === 'article') {
            $commentaireQuery->join('articles', 'articles.id = commentaires.idArticle')
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
            $formattedCommentaire = [
                'id' => $commentaire['id'],
                'contenu' => $commentaire['contenu'],
                'user' => [
                    'id' => $commentaire['idUser'],
                    'nom' => $commentaire['user_nom']
                ]
            ];

            if ($type === 'produit') {
                $formattedCommentaire['produit'] = [
                    'id' => $commentaire['idProduit'],
                    'nom' => $commentaire['produit_nom']
                ];
            } elseif ($type === 'article') {
                $formattedCommentaire['article'] = [
                    'id' => $commentaire['idArticle'],
                    'nom' => $commentaire['article_nom']
                ];
            }

            $formattedCommentaires[] = $formattedCommentaire;
        }

        return $this->respond($formattedCommentaires);
    }





    public function create()
    {
        $idProduit = $this->request->getVar('idProduit');
        $idArticle = $this->request->getVar('idArticle');

        if ($idProduit && $idArticle) {
            return $this->fail('A comment cannot be linked to both a product and an article at the same time.');
        }

        if (!$idProduit && !$idArticle) {
            return $this->fail('A comment must be linked to either a product or an article.');
        }

        $data = [
            'contenu' => $this->request->getVar('contenu'),
            'idProduit' => $idProduit ? $idProduit : null,
            'idArticle' => $idArticle ? $idArticle : null,
            'idUser' => $this->request->getVar('idUser'),
        ];

        $this->commentaireModel->insert($data);

        return $this->respond(['message' => 'Commentaire created successfully']);
    }
}

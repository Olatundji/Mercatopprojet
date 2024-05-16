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

    public function search() {
        $keyword = $this->request->getGet('keyword');

        $results = $this->commentaireModel->searchCommentaires($keyword);

        return $this->respond($results);
    }

    public function index()
{
    // Récupérer la page actuelle à partir de la requête GET
    $page = $this->request->getVar('page') ?? 1;

    // Définir le nombre d'éléments par page
    $perPage = 10;

    // Récupérer tous les produits depuis la base de données avec les détails de la marque et de la catégorie
    $Commentaires = $this->commentaireModel
                    ->select('commentaires.*, produit.nom as produit_nom, articles.contenu as article_nom , users.nom as user_nom' )
                    ->join('produit', 'produit.id = commentaires.idProduit')
                    ->join('articles', 'articles.id = commentaires.idArticle')
                    ->join('users', 'users.id = commentaires.idUser')
                    ->paginate($perPage, 'default', $page);

    if (empty($commentaires)) {
        return $this->respond(['message' => 'No commentaire found'], 404);
    }

    // Formatter la réponse avec les détails de la marque et de la catégorie
    $formattedCommentaires = [];
    foreach ($Commentaires as $commentaire) {
        $formattedCommentaires[] = [
            'id' => $commentaire['id'],
            'contenu' => $commentaire['contenu'],
            'produit' => [
                'id' => $commentaire['idProduit'],
                'nom' => $commentaire['produit_nom']
            ],
            'article' => [
                'id' => $commentaire['idArticle'],
                'nom' => $commentaire['article_nom']
            ],
            'user' => [
                'id' => $commentaire['idUser'],
                'nom' => $commentaire['user_nom']
            ]
        ];
    }

    // Retourner la liste des produits formatés avec les détails de la marque et de la catégorie
    return $this->respond($formattedCommentaires);
}



public function create()
{
    // Valider les données soumises
    if (!$this->validate($this->commentaireModel->validationRules)) {
        // Si la validation échoue, renvoyer les erreurs de validation
        return $this->failValidationErrors($this->validator->getErrors());
    }

    // Les données sont valides, continuez le traitement
    // Récupérer les données envoyées dans la requête
    $data = [
        'contenu' => $this->request->getVar('nom'),
        'idProduit' => $this->request->getVar('idProduit'),
        'idArticle' => $this->request->getVar('idArticle'),
        'idUser' => $this->request->getVar('idUser'),
    ];

    $this->commentaireModel->insert($data);

    return $this->respond(['message' => 'commentaire created successfully']);
}


    public function delete($id)
    {
        $this->commentaireModel->delete($id);

        return $this->respondDeleted(['message' => 'commentaire deleted successfully']);
    }
}

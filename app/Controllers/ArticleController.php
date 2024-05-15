<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\ArticleModel;

class ArticleController extends BaseController
{
    use ResponseTrait;

    private $articleModel;

    public function __construct()
    {
        $this->articleModel = new ArticleModel();
    }

    public function search() {
        $keyword = $this->request->getGet('keyword');

        $results = $this->articleModel->searchArticles($keyword);

        return $this->respond($results);
    }

    

    public function index()
{
    // Récupérer la page actuelle à partir de la requête GET
    $page = $this->request->getVar('page') ?? 1;

    // Définir le nombre d'éléments par page
    $perPage = 10;

    // Récupérer tous les produits depuis la base de données avec les détails de la marque et de la catégorie
    $articles = $this->articleModel
                    ->select('articles.*, categorie_articles.libelle as categorie_nom')
                    ->join('categorie_articles', 'categorie_articles.id = articles.idCategorie_article')
                    ->paginate($perPage, 'default', $page);

    // Vérifier s'il y a des produits
    if (empty($articles)) {
        // Aucun produit trouvé
        return $this->respond(['message' => 'No articles found'], 404);
    }

    // Formatter la réponse avec les détails de la marque et de la catégorie
    $formattedArticles = [];
    foreach ($articles as $article) {
        $formattedArticles[] = [
            'id' => $article['id'],
            'contenu' => $article['contenu'],
            'image' => $article['image'],
            'description' => $article['description'],
            'titre' => $article['titre'],
            'categorie' => [
                'id' => $article['idCategorie_article'],
                'nom' => $article['categorie_nom']
            ]
        ];
    }

    // Retourner la liste des produits formatés avec les détails de la marque et de la catégorie
    return $this->respond($formattedArticles);
}





    public function create()
    {
        // Récupérer les données envoyées dans la requête
        $data = [
            'contenu' => $this->request->getVar('contenu'),
            'image' => $this->request->getVar('image'),
            'description' => $this->request->getVar('description'),
            'titre' => $this->request->getVar('titre'),
            'idCategorie_article' => $this->request->getVar('idCategorie_article'),

        ];

        // Insérer le nouveau produit dans la base de données
        $this->articleModel->insert($data);

        return $this->respond(['message' => 'article created successfully']);
    }

    public function update($id)
    {
        // Récupérer les données envoyées dans la requête
        $data = [
            'contenu' => $this->request->getVar('contenu'),
            'image' => $this->request->getVar('image'),
            'description' => $this->request->getVar('description'),
            'titre' => $this->request->getVar('titre'),
            'idCategorie_article' => $this->request->getVar('idCategorie_article'),

        ];

        // Mettre à jour le produit dans la base de données
        $this->articleModel->update($id, $data);

        return $this->respond(['message' => 'article updated successfully']);
    }

    public function delete($id)
    {
        // Supprimer le produit de la base de données
        $this->articleModel->delete($id);

        return $this->respondDeleted(['message' => 'article deleted successfully']);
    }
    public function rechercheParCategorie($idCategorie_article) {
        // Récupérer les produits de la catégorie spécifiée depuis la base de données
        $articles = $this->articleModel->where('idCategorie_article', $idCategorie_article)->findAll();
    
        // Vérifier s'il y a des produits dans la catégorie spécifiée
        if (empty($articles)) {
            // Aucun produit trouvé dans la catégorie spécifiée
            return $this->failNotFound('No article found in this category');
        }
    
        // Retourner la liste des produits de la catégorie spécifiée
        return $this->respond($articles);
    }
}

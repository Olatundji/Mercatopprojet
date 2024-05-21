<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\ArticleModel;
use Config\Services;

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
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 10;
        $articles = $this->articleModel
                        ->select('articles.*, categorie_articles.libelle as categorie_nom')
                        ->join('categorie_articles', 'categorie_articles.id = articles.idCategorie_article')
                        ->paginate($perPage, 'default', $page);

        if (empty($articles)) {
            return $this->respond(['message' => 'No articles found'], 404);
        }

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

        return $this->respond($formattedArticles);
    }

    public function create()
    {
        $file = $this->request->getFile('image');
        $data = $this->request->getPost();

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $filePath = 'uploads/' . $fileName;
            $file->move('uploads', $fileName);

            $baseURL = config('App')->baseURL;
            $fullPath = $baseURL . $filePath;

            $data['image'] = $fullPath;
        }

        $this->articleModel->insert($data);

        return $this->respond(['message' => 'Article created successfully']);
    }

    public function update($id)
    {
        $file = $this->request->getFile('image');
        $data = $this->request->getPost();

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $filePath = 'uploads/' . $fileName;
            $file->move('uploads', $fileName);

            $baseURL = config('App')->baseURL;
            $fullPath = $baseURL . $filePath;

            $data['image'] = $fullPath;
        }

        $this->articleModel->update($id, $data);

        return $this->respond(['message' => 'Article updated successfully']);
    }

    public function delete($id)
    {
        $this->articleModel->delete($id);
        return $this->respondDeleted(['message' => 'Article deleted successfully']);
    }

    public function rechercheParCategorie($idCategorie_article) {
        $articles = $this->articleModel->where('idCategorie_article', $idCategorie_article)->findAll();
        if (empty($articles)) {
            return $this->failNotFound('No article found in this category');
        }
        return $this->respond($articles);
    }
}

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

    public function show($id)
    {
        $article = $this->articleModel
            ->select('articles.*, categorie_articles.libelle as categorie_nom')
            ->join('categorie_articles', 'categorie_articles.id = articles.idCategorie_article')
            ->find($id);

        if (!$article) {
            return $this->failNotFound('Article not found');
        }

        $formattedArticle = [
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

        return $this->respond($formattedArticle);
    }


    public function search()
    {
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
        $validation = \Config\Services::validation();
        $validation->setRules($this->articleModel->validationRules);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->failValidationErrors($validation->getErrors());
        }

        $file = $this->request->getFile('image');
        $data = [
            'contenu' => $this->request->getVar('contenu'),
            'description' => $this->request->getVar('description'),
            'titre' => $this->request->getVar('titre'),
            'idCategorie_article' => $this->request->getVar('idCategorie_article')
        ];

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $filePath = 'uploads/' . $fileName;

            if (!$file->move(FCPATH . 'uploads', $fileName)) {
                log_message('error', 'Failed to move file: ' . $file->getErrorString());
                return $this->failServerError('Failed to move file');
            }

            $data['image'] = base_url('uploads/' . $fileName);
        }

        try {
            if (!$this->articleModel->insert($data)) {
                log_message('error', 'Failed to insert article: ' . json_encode($this->articleModel->errors()));
                return $this->failServerError('Failed to create article');
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception caught: ' . $e->getMessage());
            return $this->failServerError('Exception: ' . $e->getMessage());
        }

        return $this->respondCreated(['message' => 'Article created successfully', 'data' => $data]);
    }

    public function update($id)
    {
        $file = $this->request->getFile('image');
        $data = [
            'contenu' => $this->request->getVar('contenu'),
            'description' => $this->request->getVar('description'),
            'titre' => $this->request->getVar('titre'),
            'idCategorie_article' => $this->request->getVar('idCategorie_article')
        ];

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $filePath = 'uploads/' . $fileName;

            if (!$file->move(FCPATH . 'uploads', $fileName)) {
                log_message('error', 'Failed to move file: ' . $file->getErrorString());
                return $this->failServerError('Failed to move file');
            }

            $data['image'] = base_url('uploads/' . $fileName);
        }

        try {
            if (!$this->articleModel->update($id, $data)) {
                log_message('error', 'Failed to update article: ' . json_encode($this->articleModel->errors()));
                return $this->failServerError('Failed to update article');
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception caught: ' . $e->getMessage());
            return $this->failServerError('Exception: ' . $e->getMessage());
        }

        return $this->respond(['message' => 'Article updated successfully']);
    }

    public function delete($id)
    {
        try {
            if (!$this->articleModel->delete($id)) {
                log_message('error', 'Failed to delete article: ' . json_encode($this->articleModel->errors()));
                return $this->failServerError('Failed to delete article');
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception caught: ' . $e->getMessage());
            return $this->failServerError('Exception: ' . $e->getMessage());
        }

        return $this->respondDeleted(['message' => 'Article deleted successfully']);
    }

    public function rechercheParCategorie($idCategorie_article)
    {
        $articles = $this->articleModel->where('idCategorie_article', $idCategorie_article)->findAll();
        if (empty($articles)) {
            return $this->failNotFound('No article found in this category');
        }
        return $this->respond($articles);
    }
}

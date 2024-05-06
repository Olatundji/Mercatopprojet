<?php

namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;
use App\Models\ArticleModel;

class Articles extends \CodeIgniter\Controller
{
    use ResponseTrait;

    public function index()
    {
        $model = new ArticleModel();
        $articles = $model->findAll();
        return $this->respond($articles);
    }

    public function show($id)
    {
        $model = new ArticleModel();
        $article = $model->find($id);

        if (!$article) {
            return $this->failNotFound('Article not found');
        }

        return $this->respond($article);
    }

    public function create()
    {
        $model = new ArticleModel();

        $data = [
            'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('content'),
            'image' => $this->request->getPost('image'),
            'description' => $this->request->getPost('description'),
            'idCategorie_article' => $this->request->getPost('idCategorie_article'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $model->insert($data);

        return $this->respondCreated(['message' => 'Article created successfully']);
    }

    public function update($id)
    {
        $model = new ArticleModel();

        $data = [
            'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('content'),
            'image' => $this->request->getPost('image'),
            'description' => $this->request->getPost('description'),
            'idCategorie_article' => $this->request->getPost('idCategorie_article'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $model->update($id, $data);

        return $this->respond(['message' => 'Article updated successfully']);
    }

    public function delete($id)
    {
        $model = new ArticleModel();

        if (!$model->delete($id)) {
            return $this->fail('Failed to delete article');
        }

        return $this->respondDeleted(['message' => 'Article deleted successfully']);
    }
}

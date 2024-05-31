<?php

namespace App\Models;

use CodeIgniter\Model;

class ArticleModel extends Model
{
    protected $table            = 'articles';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = ['contenu', 'titre', 'image', 'description', 'idCategorie_article'];


    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'contenu' => 'required',
        //'image' => 'required',
        'description' => 'required',
        'titre' => 'required',
        // 'idCategorie_article' => 'required',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function commentaire()
    {
        return $this->belongsTo(CommentaireModel::class);
    }
    public function categorie_articles()
    {
        return $this->hasMany(CategorieArticleModel::class, 'idCategorie_article');
    }

    public function getArticleCommentaires($articleId)
    {
        return $this->db->table('articlecommentaires')
            ->select('articlecommentaires.contenu as commentaire_contenu, users.nom as utilisateur_nom')
            ->join('users', 'users.id = articlecommentaires.idUser')
            ->where('articlecommentaires.idArticle', $articleId)
            ->get()
            ->getResultArray();
    }
}

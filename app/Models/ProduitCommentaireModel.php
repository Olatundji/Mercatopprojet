<?php

namespace App\Models;

use CodeIgniter\Model;

class ProduitCommentaireModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'produitcommentaires';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = ['contenu', 'idUser', 'idProduit', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps        = true;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';
    protected $deletedField         = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'contenu' => 'required',

    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks       = true;
    protected $beforeInsert         = [];
    protected $afterInsert          = [];
    protected $beforeUpdate         = [];
    protected $afterUpdate          = [];
    protected $beforeFind           = [];
    protected $afterFind            = [];
    protected $beforeDelete         = [];
    protected $afterDelete          = [];
    public function getCommentairesWithUser($idProduit)
    {
        return $this->select('produitcommentaires.*, users.nom as user_name')
            ->join('users', 'users.id = produit_commentaires.idUser')
            ->where('idProduit', $idProduit)
            ->findAll();
    }
}

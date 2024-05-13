<?php
  
namespace App\Models;
  
use CodeIgniter\Model;
use COM;

class ProductModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'produit'; // Nom de la table des produits
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = ['nom', 'prix', 'description',  'qte' , 'idMarque' , 'idCategorie']; // Champs autorisés pour la création de produit
  
    // Dates
    protected $useTimestamps        = true;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';
    protected $deletedField         = 'deleted_at';
  
    // Validation
    protected $validationRules      = [
        'nom' => 'required',
        'prix' => 'required',
        'description' => 'required',
        'qte' => 'required',
        'idMarque' => 'required',
        'idCategorie' => 'required',

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

//     public function marques()
//     {
//         return $this->hasMany(MarqueModel::class, 'idMarque');
//     }
//     public function commande()
//     {
//         return $this->belongsTo(CommandeModel::class);
//     }
//     public function promotion()
//     {
//         return $this->belongsTo(PromotionModel::class);
//     }
//     public function favoris()
//     {
//         return $this->belongsTo(FavorisModel::class);
//     }
//     public function categories()
//     {
//         return $this->hasMany(CategorieModel::class, 'idCategorie');
//     }

//     public function commentaire()
//     {
//         return $this->belongsTo(CommentaireModel::class);
//     }
}

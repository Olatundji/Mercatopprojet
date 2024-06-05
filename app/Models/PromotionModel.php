<?php

namespace App\Models;

use CodeIgniter\Model;

class PromotionModel extends Model
{
    protected $table            = 'promotions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = ['code', 'reduction', 'date_debut', 'date_fin', 'idProduit', 'idCategorie', 'montant',  'created_at', 'updated_at'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'code' => 'required|is_unique[promotions.code]',
        'reduction' => 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]',
        'date_debut' => 'required|valid_date',
        'date_fin' => 'required|valid_date',
        'idProduit' => 'permit_empty|is_natural_no_zero',
        'idCategorie' => 'permit_empty|is_natural_no_zero',
        'montant' => 'permit_empty|is_natural_no_zero'

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
    public function produit()
    {
        return $this->hasMany(ProductModel::class, 'idProduit');
    }

    public function isValidPromotion($code)
    {
        // Obtient la date et l'heure actuelles
        $now = date('Y-m-d H:i:s');

        // Débogage : affiche la date actuelle et le code de promotion
        log_message('debug', 'isValidPromotion: Code - ' . $code . ', Now - ' . $now);

        // Rechercher la promotion correspondant au code fourni et qui est actuellement valide
        $promotion = $this->where('code', $code)
            ->where('date_debut <=', $now)
            ->where('date_fin >=', $now)
            ->first();

        // Débogage : affiche la promotion trouvée ou non
        log_message('debug', 'isValidPromotion: Promotion - ' . print_r($promotion, true));

        return $promotion;
    }
}

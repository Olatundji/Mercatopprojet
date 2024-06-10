<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriePromotionModel extends Model
{
    protected $table            = 'categoriepromotions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = ['code', 'reduction', 'date_debut', 'date_fin',  'idCategorie', 'created_at', 'updated_at'];

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
        'code'       => 'required',
        'reduction'  => 'required|numeric',
        'date_debut' => 'required|valid_date',
        'date_fin'   => 'required|valid_date',
        'idCategorie' => 'required|is_natural_no_zero',

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


    public function isValidPromotion($code)
    {
        $now = date('d-m-Y H:i:s');

        log_message('debug', 'isValidPromotion: Code - ' . $code . ', Now - ' . $now);

        $promotion = $this->where('code', $code)
            ->where('date_debut <=', $now)
            ->where('date_fin >=', $now)
            ->first();

        log_message('debug', 'isValidPromotion: Promotion - ' . print_r($promotion, true));

        return $promotion;
    }
}

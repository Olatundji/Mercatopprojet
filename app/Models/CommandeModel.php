<?php

namespace App\Models;

use CodeIgniter\Model;

class CommandeModel extends Model
{
    protected $table            = 'commandes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['etat', 'date', 'transaction', 'method_pay', 'montant', 'idUser'];

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
        'etat' => 'required',
        'date' => 'required',
        'transaction' => 'required',
        'method_pay' => 'required',
        'montant' => 'required',
        'idUser' => 'required',

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

    public function getSalesReport($datetDebut, $dateFin)
    {
        return $this->select('montant, SUM(montant) as total_sales, COUNT(id) as total_orders')
            ->where('date >=', $datetDebut)
            ->where('date <=', $dateFin)
            // ->groupBy('produit')
            ->findAll();
    }
    public function getSalesReportFrom2024()
    {
        return $this->select("DATE_FORMAT(date, '%Y-%m') as month, 
                              DATE_FORMAT(date, '%M %Y') as month_name, 
                              SUM(montant) as total_quantity_sold")
            ->where('date >=', '2024-01-01')
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->findAll();
    }

    public function produit()
    {
        return $this->hasMany(ProductModel::class, 'idProduit');
    }
    public function users()
    {
        return $this->hasMany(UserModel::class, 'idUser');
    }
}

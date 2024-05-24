<?php

namespace App\Models;

use CodeIgniter\Model;

class ParametreModel extends Model
{
    protected $table            = 'parametres';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = ['nom', 'logo', 'slogan', 'adresse'];

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
        'nom' => 'required|min_length[3]|max_length[255]',
        'slogan' => 'required|min_length[3]|max_length[255]',
        'adresse' => 'required|min_length[3]|max_length[255]',
        //'logo' => 'uploaded[logo]|max_size[logo,2048]|is_image[logo]|mime_in[logo,image/jpg,image/jpeg,image/gif,image/png]'
    ];
    protected $validationMessages   = [
        'nom' => [
            'required' => 'Le champ nom est requis.',
            'min_length' => 'Le champ nom doit avoir au moins 3 caractères.',
            'max_length' => 'Le champ nom ne peut pas dépasser 255 caractères.',
        ],
        'slogan' => [
            'required' => 'Le champ slogan est requis.',
            'min_length' => 'Le champ slogan doit avoir au moins 3 caractères.',
            'max_length' => 'Le champ slogan ne peut pas dépasser 255 caractères.',
        ],
        'adresse' => [
            'required' => 'Le champ adresse est requis.',
            'min_length' => 'Le champ adresse doit avoir au moins 3 caractères.',
            'max_length' => 'Le champ adresse ne peut pas dépasser 255 caractères.',
        ],
        // 'logo' => [
        //     'uploaded' => 'You must upload a valid logo file.',
        //     'max_size' => 'The logo file size must be less than 2MB.',
        //     'is_image' => 'The logo file must be an image.',
        //     'mime_in' => 'The logo file must be a type of jpg, jpeg, gif, or png.'
        // ]
    ];
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
}

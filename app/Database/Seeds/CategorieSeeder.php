<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorieSeeder extends Seeder
{
    public function run()
    {
        $data=[ 
            'libelle' => 'Categorie1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),

        ];
        $this->db->table('categories')->insertBatch($data);
    }
}

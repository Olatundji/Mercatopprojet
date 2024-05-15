<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MarqueSeeder extends Seeder
{
    public function run()
    {
        $data=[ 
            'nom' => 'marque1',

        ];
        $this->db->table('marques')->insertBatch($data);
    }
}

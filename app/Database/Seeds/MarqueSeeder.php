<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MarqueSeeder extends Seeder
{
    public function run()
    {
        $data = [];

        for ($i = 1; $i <= 10; $i++) {
            $data [] =[ 
                'nom' => 'Marque '.$i,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }
        $this->db->table('marques')->insertBatch($data);
    }
}

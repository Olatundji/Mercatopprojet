<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProduitSeeder extends Seeder
{
    public function run()
    {
        // Liste des URLs des images
        $imageUrls = [
            'http://localhost:8080/uploads/1717666800_2800af235121cf6ec6d9.jpeg',
            'http://localhost:8080/uploads/1717666895_aaab6f443996a81d5bab.jpeg',
            'http://localhost:8080/uploads/1717666936_1916a400a41b9d38269c.jpeg',
            'http://localhost:8080/uploads/1717666975_0745af23f76fd232101d.jpeg',
            'http://localhost:8080/uploads/1717667024_72bbb2740c2a52855f5e.jpeg',
            'http://localhost:8080/uploads/1717667063_280d62f4af2d261982cd.jpeg',
            'http://localhost:8080/uploads/1717667117_3b33d5136e51d2caf4ce.jpeg',
            'http://localhost:8080/uploads/1717667152_82550e61eb698f310f9d.jpeg',
            'http://localhost:8080/uploads/1717667196_4d64c8298ebf5aa11b25.jpeg',
            'http://localhost:8080/uploads/1717667233_c91397e1b373ed44bf1a.jpeg'


        ];

        foreach ($imageUrls as $imageUrl) {
            $data = [
                'nom' => 'produit ' . random_int(10, 10000),
                'prix' => rand(100, 1000),
                'description' => 'mon produit',
                'qte' => rand(1, 99),
                'image' => $imageUrl, // Utiliser l'URL de l'image
                'idMarque' => random_int(1, 10),
                'idCategorie' => random_int(1, 10),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $this->db->table('produit')->insert($data);
        }
    }
}

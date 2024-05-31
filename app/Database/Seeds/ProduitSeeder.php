<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProduitSeeder extends Seeder
{
    public function run()
    {
        // Liste des URLs des images
        $imageUrls = [
            '"http://localhost:8080/uploads/1717175680_3ad6fcd90e791bbb2263.jpeg',
            '"http://localhost:8080/uploads/1717175680_3ad6fcd90e791bbb2263.jpeg',
            '"http://localhost:8080/uploads/1717175680_3ad6fcd90e791bbb2263.jpeg',
            '"http://localhost:8080/uploads/1717175680_3ad6fcd90e791bbb2263.jpeg',


        ];

        foreach ($imageUrls as $imageUrl) {
            $data = [
                'nom' => 'produit',
                'prix' => '20',
                'description' => 'mon produit',
                'qte' => '10',
                'image' => $imageUrl, // Utiliser l'URL de l'image
                'idMarque' => '2',
                'idCategorie' => '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $this->db->table('produit')->insert($data);
        }
    }
}

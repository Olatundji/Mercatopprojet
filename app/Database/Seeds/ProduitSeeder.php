<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProduitSeeder extends Seeder
{
    public function run()
    {
        // Liste des URLs des images
        $imageUrls = [
            'http://localhost:8080/uploads/1717493740_b46a81f61b120bc2791f.jpeg',
            'http://localhost:8080/uploads/1717493787_e981216bad044a83153b.jpeg',
            'http://localhost:8080/uploads/1717493823_f73ea1fe8a49269a00a4.jpeg',
            'http://localhost:8080/uploads/1717493874_0e5e890c2407b198a341.jpeg',
            'http://localhost:8080/uploads/1717493912_a89124a87952ebfb12b9.jpeg',
            'http://localhost:8080/uploads/1717493959_c2d246b745f4dee24347.jpeg',
            'http://localhost:8080/uploads/1717494003_109b99da0e0f643b291c.jpeg',
            'http://localhost:8080/uploads/1717494046_60f59cf7778ed19a28a6.jpeg',
            'http://localhost:8080/uploads/1717494098_3436123bc8905ea0a540.jpeg',
            'http://localhost:8080/uploads/1717494160_448be7972affdc88dc28.jpeg'


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

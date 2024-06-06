<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run()
    {

        $imageUrls = [
            'http://localhost:8080/uploads/1717667389_a11a29d3cf92a0cc6bdf.jpeg',
            'http://localhost:8080/uploads/1717667436_ff964a758298c4728a27.jpeg',
            'http://localhost:8080/uploads/1717667475_4a7c78a5bb9e2968ad1d.jpeg',
            'http://localhost:8080/uploads/1717667518_c2578b2bdaa8295787f5.jpeg',
            'http://localhost:8080/uploads/1717492293_cf374c6d907a7083cc34.jpeg',
            'http://localhost:8080/uploads/1717492345_aeb5904fe05506a4c6a8.jpeg',
            'http://localhost:8080/uploads/1717667613_3e9127584cae189d9656.jpeg',
            'http://localhost:8080/uploads/1717667651_5724bb678ad9a5e3c941.jpeg',
            'http://localhost:8080/uploads/1717667698_e6f738738d0f052eb15b.jpeg',
            'http://localhost:8080/uploads/1717667742_3a56077d7cb5b5d1c654.jpeg'

        ];

        foreach ($imageUrls as $imageUrl) {
            $data = [
                'contenu' => 'Contenu de l\'article',
                'image' => $imageUrl,
                'description' => 'Description de l\'article',
                'titre' => 'Titre de l\'article',
                'idCategorie_article' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $this->db->table('articles')->insert($data);
        }
    }
}

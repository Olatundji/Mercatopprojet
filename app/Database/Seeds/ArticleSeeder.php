<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run()
    {

        $imageUrls = [
            'http://localhost:8080/uploads/1717175814_8950c7f4f2025be683c2.jpeg',
            'http://localhost:8080/uploads/1717175814_8950c7f4f2025be683c2.jpeg',
            'http://localhost:8080/uploads/1717175814_8950c7f4f2025be683c2.jpeg',
            'http://localhost:8080/uploads/1717175814_8950c7f4f2025be683c2.jpeg',
            'http://localhost:8080/uploads/1717175814_8950c7f4f2025be683c2.jpeg',
            'http://localhost:8080/uploads/1717175814_8950c7f4f2025be683c2.jpeg',
            'http://localhost:8080/uploads/1717175814_8950c7f4f2025be683c2.jpeg',
            'http://localhost:8080/uploads/1717175814_8950c7f4f2025be683c2.jpeg',
            'http://localhost:8080/uploads/1717175814_8950c7f4f2025be683c2.jpeg',
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

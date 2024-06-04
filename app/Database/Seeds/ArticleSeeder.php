<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run()
    {

        $imageUrls = [
            'http://localhost:8080/uploads/1717175814_8950c7f4f2025be683c2.jpeg',
            'http://localhost:8080/uploads/1717491894_68cc581a19771104356b.jpeg',
            'http://localhost:8080/uploads/1717492143_da55aca18f1ee92eadbf.jpeg',
            'http://localhost:8080/uploads/1717492251_b5e1b1454a4642c7bede.jpeg',
            'http://localhost:8080/uploads/1717492293_cf374c6d907a7083cc34.jpeg',
            'http://localhost:8080/uploads/1717492345_aeb5904fe05506a4c6a8.jpeg',
            'http://localhost:8080/uploads/1717492387_06b42ffc7e9c6a498ef1.jpeg',
            'http://localhost:8080/uploads/1717492439_667a9f58715d31d6163c.jpeg',
            'http://localhost:8080/uploads/1717492485_816490aed82e15b35d5e.jpeg',
            'http://localhost:8080/uploads/1717492542_0764351919a4c5edd0a6.jpeg'

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

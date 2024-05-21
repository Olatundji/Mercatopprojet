<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        $uploadPath = WRITEPATH . 'uploads/';
        $images = [
            'image1.jpeg',
            'image2.jpeg',
            'image3.jpeg',
            'image4.jpeg',
            'image5.jpeg',
            'image6.jpeg',
            'image7.jpeg',
            'image8.jpeg',
            'image9.jpeg',
        ];

        foreach ($images as $imageName) {
            $sourceImagePath = FCPATH . 'images/' . $imageName;

            $destinationImagePath = $uploadPath . $imageName;

            if (copy($sourceImagePath, $destinationImagePath)) {
                $data = [
                    'contenu' => 'Contenu de l\'article',
                    'image' => $imageName, 
                    'description' => 'Description de l\'article',
                    'titre' => 'Titre de l\'article',
                    'idCategorie_article' => 1, 
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];

                $this->db->table('articles')->insert($data);
            } else {
                echo "Erreur lors du téléchargement de l'image.";
            }
        }
    }
}

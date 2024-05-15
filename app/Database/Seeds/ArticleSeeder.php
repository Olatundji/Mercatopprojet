<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        // Définissez votre chemin de téléchargement
        $uploadPath = WRITEPATH . 'uploads/';

        // Définissez les noms des images pour chaque article
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

        // Boucle pour insérer 9 articles
        foreach ($images as $imageName) {
            // Définissez le chemin complet de l'image source
            $sourceImagePath = FCPATH . 'images/' . $imageName;

            // Définissez le chemin complet de l'image de destination
            $destinationImagePath = $uploadPath . $imageName;

            // Copiez l'image
            if (copy($sourceImagePath, $destinationImagePath)) {
                // Insérez les données dans la base de données avec le chemin de l'image
                $data = [
                    'contenu' => 'Contenu de l\'article',
                    'image' => $imageName, // Enregistrez le nom du fichier de l'image dans la colonne 'image'
                    'description' => 'Description de l\'article',
                    'titre' => 'Titre de l\'article',
                    'idCategorie_article' => 1, // ID de la catégorie de l'article
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

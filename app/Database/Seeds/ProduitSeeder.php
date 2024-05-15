<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProduitSeeder extends Seeder
{
    public function run()
    {

        $uploadPath = WRITEPATH . 'uploads/';
        $images = [
            'image1.jpeg',
            'image6.jpeg',
            'image7.jpeg',
            'image8.jpeg',
        ];

        foreach ($images as $imageName) {
            $sourceImagePath = FCPATH . 'images/' . $imageName;

            $destinationImagePath = $uploadPath . $imageName;

            if (copy($sourceImagePath, $destinationImagePath)) {
                $data=[ 
                    'nom' => 'produit',
                    'prix' => '20',
                    'description' => 'mon produit',
                    'qte' => '10',
                    'image'=> $imageName,
                    'idMarque' => '1',
                    'idCategorie' => '1',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];

                $this->db->table('produit')->insert($data);
            } else {
                echo "Erreur lors du téléchargement de l'image.";
            }
        }
        
    }
}

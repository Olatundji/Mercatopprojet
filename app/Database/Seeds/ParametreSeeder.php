<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ParametreSeeder extends Seeder
{
    public function run()
    {
        $uploadPath = WRITEPATH . 'uploads/';
        $images = [
            'image1.jpeg',
        ];

        foreach ($images as $imageName) {
            $sourceImagePath = FCPATH . 'images/' . $imageName;

            $destinationImagePath = $uploadPath . $imageName;

            if (copy($sourceImagePath, $destinationImagePath)) {
                $data=[ 
                    'nom' => 'Mercatop',
                    'logo' => $imageName,
                    'slogan' => 'merca',
                    'adresse' => 'calavi',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];

                $this->db->table('parametres')->insert($data);
            } else {
                echo "Erreur lors du téléchargement de l'image.";
            }
        }
    }
}

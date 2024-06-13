<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'nom' => 'Admin',
            'numero' => '97123515',
            'adresse' => 'Cotonou',
            'email' => 'admin@gmail.com',
            'user_type' => 'admin',
            'password' => password_hash('azerty',PASSWORD_DEFAULT)
        ];
        $this->db->table('users')->insertBatch($data);
    }
}






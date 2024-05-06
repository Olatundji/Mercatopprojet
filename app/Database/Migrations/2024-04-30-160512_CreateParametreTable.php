<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateParametreTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nom' => [
                'type' => 'VARCHAR',
                'constraint' => 255, 
                'null' => true, 
            ],

            'logo' => [
                'type' => 'VARCHAR',
                'constraint' => 20, 
                'null' => false, 
            ],
            'slogan' => [
                'type' => 'TEXT',
                'null' => false, 
            ],
            'adresse' => [
                'type' => 'TEXT',
                'null' => false, 
            ],
            
            // Ajoutez d'autres colonnes si nécessaire
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('parametres');
    }

    public function down()
    {
        $this->forge->dropTable('parametres');
    }
}

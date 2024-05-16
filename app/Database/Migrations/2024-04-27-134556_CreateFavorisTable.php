<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFavorisTable extends Migration
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
            'idProduit' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
             'idUser' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
               'null' => true,
             ],
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
        $this->forge->addForeignKey('idProduit', 'produit', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('idUser', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('favoris');
    }

    public function down()
    {
        $this->forge->dropTable('favoris');
        
    }
}

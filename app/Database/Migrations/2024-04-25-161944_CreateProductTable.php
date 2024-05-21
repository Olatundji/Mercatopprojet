<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductTable extends Migration
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
                'constraint' => 100,
            ],
            'prix' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'qte' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => 255, // Taille de la chaîne spécifiée
                'null' => true, // Définition de la colonne NOT NULL
            ],
            'idMarque' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'idCategorie' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
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
        $this->forge->addForeignKey('idMarque', 'marques', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('idCategorie', 'categories', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('produit');
    }

    public function down()
    {
        $this->forge->dropTable('produit');
    }
}

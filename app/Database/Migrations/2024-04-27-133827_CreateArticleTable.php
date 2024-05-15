<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateArticleTable extends Migration
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
            'contenu' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => 100, // Ajout de la contrainte de longueur
            ],
            'description' => [
                'type' => 'TEXT',
            ],
            'titre' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'idCategorie_article' => [
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
        $this->forge->addForeignKey('idCategorie_article', 'categorie_articles', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('articles');
    }

    public function down()
    {
        $this->forge->dropTable('articles');
    }
}

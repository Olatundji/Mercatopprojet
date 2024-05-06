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
                'null' => false,
            ],
            'image' => [
                'type' => 'BLOB', 
                'null' => false,
            ],
            'description' => [
                'type' => 'TEXT', 
                'null' => true,
            ],
            'titre' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'idCategorie_article' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
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
        $this->forge->addForeignKey('idCategorie_article', 'categorie_articles', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('articles');
    }

    public function down()
    {
        $this->forge->dropTable('articles');
    }
}

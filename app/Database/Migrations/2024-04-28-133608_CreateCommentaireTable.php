<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCommentaireTable extends Migration
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
            'idUser' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'idArticle' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'idProduit' => [
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
        $this->forge->addForeignKey('idUser', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('idArticle', 'articles', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('idProduit', 'produit', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('commentaires');
    }

    public function down()
    {
        $this->forge->dropTable('commentaires');
    }
}

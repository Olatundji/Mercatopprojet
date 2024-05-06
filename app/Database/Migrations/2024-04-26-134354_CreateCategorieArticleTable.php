<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCategorieArticleTable extends Migration
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
            'libelle' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,

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
        $this->forge->createTable('categorie_articles');
    }

    public function down()
    {
        $this->forge->dropTable('categorie_articles');
    }
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCategoriePromotionTable extends Migration
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
            'code' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],

            'reduction' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false,
            ],
            'date_debut' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'date_fin' => [
                'type' => 'DATE',
                'null' => false,
            ],

            'idCategorie' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,

            ],


            // 'idUser' => [
            //     'type' => 'INT',
            //     'constraint' => 11,
            //     'unsigned' => true,
            // ],

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
        $this->forge->addForeignKey('idCategorie', 'categories', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('categoriepromotions');
    }

    public function down()
    {
        $this->forge->dropTable('categoriepromotions');
    }
}

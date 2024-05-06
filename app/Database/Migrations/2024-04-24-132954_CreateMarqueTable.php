<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMarqueTable extends Migration
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
        $this->forge->createTable('marques');
    }

    public function down()
    {
        $this->forge->dropTable('marques');
    }
}

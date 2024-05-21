<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUploadTable extends Migration
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
            'file_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'original_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'file_type' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'file_size' => [
                'type' => 'INT', 
                'constraint' => 11,
            ],
            'file_path' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
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
        $this->forge->createTable('uploads');
    }

    public function down()
    {
        $this->forge->dropTable('uploads');
    }
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCommandeTable extends Migration
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
            'etat' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'date' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'transaction' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'method_pay' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'montant' => [
                'type' => 'INT',
                'null' => false,
            ],
            'idUser' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            
            // Ajoutez d'autres colonnes si nécessaire
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('idUser', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('commandes');
    }

    public function down()
    {
        $this->forge->dropTable('commandes');
    }
}
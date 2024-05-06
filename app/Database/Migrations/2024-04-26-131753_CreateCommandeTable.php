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
                'type' => 'TEXT',
                'constraint' => 100,
                'null' => false, 
            ],
            'date' => [
                'type' => 'DATE',
                'null' => false, 
            ],
            'transaction' => [
                'type' => 'INT',
                'constraint' => 11,
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
            'idProduit' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            // 'idUser' => [
            //     'type' => 'BIGINT',
            //     'constraint' => 11,
            //     'unsigned' => true,
            // ],
            
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
        $this->forge->addForeignKey('idProduit', 'produit', 'id', 'CASCADE', 'CASCADE');
        //$this->forge->addForeignKey('idUser', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('commandes');
    }

    public function down()
    {
        $this->forge->dropTable('commandes');
    }
}

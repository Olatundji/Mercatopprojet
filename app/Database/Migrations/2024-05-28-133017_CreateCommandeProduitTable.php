<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCommandeProduitTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'commande_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'produit_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'quantite' => [
                'type' => 'INT',
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
        $this->forge->addForeignKey('commande_id', 'commandes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('produit_id', 'produit', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('commandeproduit');
    }

    public function down()
    {
        $this->forge->dropTable('commandeproduit');
    }
}

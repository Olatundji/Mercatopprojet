<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCommandeProduitTable extends Migration
{
    public function up()
    {
        // Création de la table commandeproduit
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'commande_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'produit_id' => [
                'type' => 'INT',
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
        $this->forge->addForeignKey('produit_id', 'produits', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('commandeproduit');
    }

    public function down()
    {
        $this->forge->dropTable('commandeproduit');
    }
}

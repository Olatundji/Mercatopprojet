<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'total_amount', 'transaction_id', 'status', 'created_at', 'updated_at'];

    public function getSalesReport()
    {
        // Logique pour récupérer les données de rapport de vente
        // Exemple: nombre de produits vendus, prix total des ventes, etc.
        // Vous devez implémenter cette logique en fonction de vos besoins spécifiques.
        // Cela pourrait impliquer des requêtes SQL pour agréger les données de commande.

        // Exemple simplifié:
        $totalSales = $this->db->query('SELECT SUM(total_amount) AS total_sales FROM orders')->getRow()->total_sales;
        $totalOrders = $this->countAll();

        return [
            'total_sales' => $totalSales,
            'total_orders' => $totalOrders
            // Ajoutez d'autres données de rapport de vente selon vos besoins
        ];
    }
}

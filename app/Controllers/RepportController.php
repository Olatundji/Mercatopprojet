<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\CommandeModel;
use App\Models\ProductModel;
use App\Models\UserModel;

use CodeIgniter\Controller;

class RepportController extends Controller
{
    use ResponseTrait;

    public function salesReport()
    {
        $dateDebut = $this->request->getGet('date_debut');
        $dateFin = $this->request->getGet('date_fin');

        if (is_null($dateDebut) || is_null($dateFin)) {
            return $this->fail('Start date and end date are required', 400);
        }

        $commandeModel = new CommandeModel();
        $report = $commandeModel->getSalesReport($dateDebut, $dateFin);

        return $this->respond($report);
    }

    public function getBestSellingProducts($startDate, $endDate)
    {
        $commandeModel = new CommandeModel();
        $productModel = new ProductModel();

        $bestSellingProducts = $commandeModel
            ->select('idProduit, SUM(qte) as total_quantity_sold')
            ->where('date >=', $startDate)
            ->where('date <=', $endDate)
            ->groupBy('idProduit')
            ->orderBy('total_quantity_sold', 'DESC')
            ->findAll();

        $produit = [];
        foreach ($bestSellingProducts as $product) {
            $productDetails = $productModel->find($product['idProduit']);
            if ($productDetails) {
                $products[] = [
                    'idProduit' => $productDetails['idProduit'],
                    'nom' => $productDetails['nom'],
                    'total_quantity_sold' => $product['total_quantity_sold']
                ];
            }
        }

        return $this->respond($produit);
    }
    public function getUserReport()
    {
        $userModel = new UserModel();

        $totalUsers = $userModel->countAll();

        $nom = $userModel->select('nom')->findAll();

        return json_encode([
            'total_users' => $totalUsers,
            'user_names' => $nom
        ]);
    }
}

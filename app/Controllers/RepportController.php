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

    private $moisFrancais = [
        'January' => 'Janvier',
        'February' => 'Février',
        'March' => 'Mars',
        'April' => 'Avril',
        'May' => 'Mai',
        'June' => 'Juin',
        'July' => 'Juillet',
        'August' => 'Août',
        'September' => 'Septembre',
        'October' => 'Octobre',
        'November' => 'Novembre',
        'December' => 'Décembre',
    ];

    public function salesReport()
    {
        $dateDebut = '2024-01-01';
        $dateFin = '2024-12-31';

        $commandeModel = new CommandeModel();

        $query = $commandeModel->select("DATE_FORMAT(date, '%M %Y') as mois, SUM(montant) as total_vente")
            ->where('date >=', $dateDebut)
            ->where('date <=', $dateFin)
            ->groupBy("DATE_FORMAT(date, '%M %Y')")
            ->orderBy("YEAR(date)", 'ASC')
            ->orderBy("MONTH(date)", 'ASC')
            ->get();

        $report = $query->getResultArray();

        $moisFr = [
            'January' => 'Janvier',
            'February' => 'Février',
            'March' => 'Mars',
            'April' => 'Avril',
            'May' => 'Mai',
            'June' => 'Juin',
            'July' => 'Juillet',
            'August' => 'Août',
            'September' => 'Septembre',
            'October' => 'Octobre',
            'November' => 'Novembre',
            'December' => 'Décembre'
        ];

        $moisAnnee = [];
        for ($i = 1; $i <= 12; $i++) {
            $date = \DateTime::createFromFormat('!m', $i);
            $moisAnnee[$date->format('F Y')] = [
                'mois' => $moisFr[$date->format('F')] . ' 2024',
                'total_vente' => 0
            ];
        }

        foreach ($report as $item) {
            $moisAnnee[$item['mois']]['total_vente'] = $item['total_vente'];
        }

        return $this->respond(array_values($moisAnnee));
    }
    public function getUserReport()
    {
        $userModel = new UserModel();

        $totalUsers = $userModel->countAll();
        $noms = $userModel->select('nom')->findAll();

        return $this->respond([
            'total_utilisateurs' => $totalUsers,
            'noms_utilisateurs' => $noms
        ]);
    }


    public function salesReporte()
    {
        $monthlySales = [];

        $monthsFr = [
            'January' => 'Janvier',
            'February' => 'Février',
            'March' => 'Mars',
            'April' => 'Avril',
            'May' => 'Mai',
            'June' => 'Juin',
            'July' => 'Juillet',
            'August' => 'Août',
            'September' => 'Septembre',
            'October' => 'Octobre',
            'November' => 'Novembre',
            'December' => 'Décembre'
        ];

        foreach ($monthsFr as $en => $fr) {
            $monthlySales[$fr] = rand(1000, 5000);
        }

        return $this->respond($monthlySales);
    }
}

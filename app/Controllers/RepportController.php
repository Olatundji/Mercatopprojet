<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\CommandeModel;

class RepportController extends BaseController
{
    use ResponseTrait;

    private $commandeModel;

    public function __construct()
    {
        $this->commandeModel = new CommandeModel();
    }

    public function salesReport()
    {
        $salesData = $this->commandeModel->getSalesReport();

        return $this->respond($salesData);
    }
}

<?php

namespace App\Controllers\Api;

use App\Models\ParametreModel;
use CodeIgniter\API\ResponseTrait;
use App\Models\SettingModel;

class Parametre extends \CodeIgniter\Controller
{
    use ResponseTrait;

    public function index()
    {
        $model = new ParametreModel();
        $settings = $model->findAll();
        return $this->respond($settings);
    }

    public function update($id)
    {
        $model = new ParametreModel();

        $data = [
            'name' => $this->request->getVar('nom'),
            'logo' => $this->request->getVar('logo'),
            'slogan' => $this->request->getVar('slogan'),
            'address' => $this->request->getVar('address'),
        ];

        $model->update($id, $data);

        return $this->respond(['message' => 'Settings updated successfully']);
    }
}

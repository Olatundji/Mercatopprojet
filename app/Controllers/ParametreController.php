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
            'name' => $this->request->getPost('nom'),
            'logo' => $this->request->getPost('logo'),
            'slogan' => $this->request->getPost('slogan'),
            'address' => $this->request->getPost('address'),
        ];

        $model->update($id, $data);

        return $this->respond(['message' => 'Settings updated successfully']);
    }
}

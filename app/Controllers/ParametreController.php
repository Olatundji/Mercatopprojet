<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\ParametreModel;

class ParametreController extends BaseController
{
    use ResponseTrait;

    private $parametreModel;

    public function __construct()
    {
        $this->parametreModel = new ParametreModel();
    }

    public function update($id)
    {
        log_message('debug', 'Updating parameters with ID: ' . $id);

        $validation = \Config\Services::validation();
        $validation->setRules($this->parametreModel->validationRules);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->failValidationErrors($validation->getErrors());
        }

        $data = [
            'nom' => $this->request->getVar('nom'),
            'slogan' => $this->request->getVar('slogan'),
            'adresse' => $this->request->getVar('adresse')
        ];

        $file = $this->request->getFile('logo');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $filePath = WRITEPATH . 'uploads/' . $fileName;
            if ($file->move(WRITEPATH . 'uploads', $fileName)) {
                log_message('debug', 'Logo file moved successfully to: ' . $filePath);
                $data['logo'] = $filePath;
            } else {
                log_message('error', 'Failed to move logo file');
                return $this->failServerError('Failed to move logo file');
            }
        }

        if (!$this->parametreModel->update($id, $data)) {
            log_message('error', 'Failed to update parameters: ' . json_encode($this->parametreModel->errors()));
            return $this->failValidationErrors($this->parametreModel->errors());
        }

        log_message('debug', 'Parameters updated successfully');

        return $this->respond(['message' => 'Parameters updated successfully']);
    }
}

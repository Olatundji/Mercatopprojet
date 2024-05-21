<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\PromotionModel;
use App\Models\ProductModel;


class PromotionController extends ResourceController
{
    protected $modelName = 'App\Models\PromotionModel';
    protected $format    = 'json';
    protected $produitModel; 
    public function __construct()
    {
        $this->produitModel = new ProductModel();
    }
    public function create()
    {
        $data = $this->request->getVar();

        if (!$this->validate([
            'code'       => 'required',
            'reduction'  => 'required',
            'date_debut' => 'required|valid_date',
            'date_fin'   => 'required|valid_date',
            'idProduit'  => 'required|is_natural_no_zero',
        ])) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        if ($this->model->save($data)) {
            return $this->respondCreated(['message' => 'Promotion created successfully']);
        } else {
            return $this->failServerError('Failed to create promotion');
        }
    }

public function usePromoCode()
{
    $code = $this->request->getVar('code');
    $idProduit = $this->request->getVar('idProduit');
    $idUser = $this->request->getVar('idUser');

    if (empty($code)) {
        return $this->failValidationErrors(['code' => 'Promotion code is required']);
    }

    if (empty($idProduit)) {
        return $this->failValidationErrors(['idProduit' => 'Product ID is required']);
    }

    if (empty($idUser)) {
        return $this->failValidationErrors(['idUser' => 'User ID is required']);
    }

    $promotion = $this->model->isValidPromotion($code);

    if ($promotion) {
        if ($promotion['idProduit'] != $idProduit) {
            return $this->failNotFound('Promotion code is not valid for this product');
        }

        $produit = $this->produitModel->find($idProduit);
        if (!$produit) {
            return $this->failNotFound('Product not found');
        }

        $reduction = floatval($promotion['reduction']);
        $prixOriginal = floatval($produit['prix']);
        $nouveauPrix = $prixOriginal - ($prixOriginal * ($reduction / 100));

        $this->produitModel->update($idProduit, ['prix' => $nouveauPrix]);

        return $this->respond([
            'message' => 'Promotion code applied successfully',
            'promotion' => $promotion,
            'nouveauPrix' => $nouveauPrix
        ]);
    } else {
        return $this->failNotFound('Promotion code is invalid or expired');
    }
}

}

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

    public function createProductPromotion()
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
            return $this->respondCreated(['message' => 'Promotion créée avec succès']);
        } else {
            return $this->failServerError('Échec de la création de la promotion');
        }
    }

    public function createCategoryPromotion()
    {
        $data = $this->request->getVar();

        if (!$this->validate([
            'code'       => 'required',
            'reduction'  => 'required|decimal',
            'date_debut' => 'required|valid_date',
            'date_fin'   => 'required|valid_date',
            'idCategorie' => 'required|is_natural_no_zero',
        ])) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        if ($this->model->save($data)) {
            return $this->respondCreated(['message' => 'Promotion créée avec succès']);
        } else {
            return $this->failServerError('Échec de la création de la promotion');
        }
    }

    public function usePromoCode()
    {
        $code = $this->request->getVar('code');
        $panier = $this->request->getVar('panier');
        $idUser = $this->request->getVar('idUser');

        if (empty($code)) {
            return $this->failValidationErrors(['code' => 'Un code promotionnel est requis']);
        }

        if (empty($idUser)) {
            return $this->failValidationErrors(['idUser' => 'L’identifiant utilisateur est requis']);
        }

        if (empty($panier)) {
            return $this->failValidationErrors(['panier' => 'Panier est obligatoire']);
        }

        $promotion = $this->model->isValidPromotion($code);

        if ($promotion) {
            $totalReduction = 0;
            $updatedPanier = [];

            foreach ($panier as $item) {
                if (isset($item['idProduit']) && !empty($promotion['idProduit']) && $promotion['idProduit'] == $item['idProduit']) {
                    $item = $this->applyPromotionToProduct($promotion, $item);
                } elseif (isset($item['idCategorie']) && !empty($promotion['idCategorie']) && $promotion['idCategorie'] == $item['idCategorie']) {
                    $item = $this->applyPromotionToCategory($promotion, $item);
                }
                $updatedPanier[] = $item;
                $totalReduction += $item['reduction'] ?? 0;
            }

            return $this->respond([
                'message' => 'Code promotionnel appliqué avec succès',
                'promotion' => $promotion,
                'totalReduction' => $totalReduction,
                'updatedPanier' => $updatedPanier
            ]);
        } else {
            return $this->failNotFound('Le code promotionnel n’est pas valide ou a expiré');
        }
    }

    private function applyPromotionToProduct($promotion, $item)
    {
        $produit = $this->produitModel->find($item['idProduit']);
        if (!$produit) {
            return $item;
        }

        $reduction = floatval($promotion['reduction']);
        $prixOriginal = floatval($produit['prix']);
        $nouveauPrix = $prixOriginal - ($prixOriginal * ($reduction / 100)) * $item['quantite'];
        $item['prix'] = $nouveauPrix;
        $item['reduction'] = ($prixOriginal - $nouveauPrix) * $item['quantite'];
        $item['prixOriginal'] = $prixOriginal;

        return $item;
    }

    private function applyPromotionToCategory($promotion, $item)
    {
        $produit = $this->produitModel->find($item['idProduit']);
        if (!$produit) {
            return $item;
        }

        $reduction = floatval($promotion['reduction']);
        $prixOriginal = floatval($produit['prix']);
        $nouveauPrix = $prixOriginal - ($prixOriginal * ($reduction / 100)) * $item['quantite'];
        $item['prix'] = $nouveauPrix;
        $item['reduction'] = ($prixOriginal - $nouveauPrix) * $item['quantite'];
        $item['prixOriginal'] = $prixOriginal;

        return $item;
    }
}

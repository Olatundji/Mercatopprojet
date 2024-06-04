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

        if (empty($panier) || !is_array($panier)) {
            return $this->failValidationErrors(['panier' => 'Panier est obligatoire et doit être un tableau']);
        }

        if (empty($idUser)) {
            return $this->failValidationErrors(['idUser' => 'L’identifiant utilisateur est requis']);
        }

        $promotion = $this->model->isValidPromotion($code);

        if (!$promotion) {
            return $this->failNotFound('Le code promotionnel n’est pas valide ou a expiré');
        }

        $idProduitPromo = $promotion['idProduit'];
        $reduction = floatval($promotion['reduction']);
        $produitMisAJour = false;

        foreach ($panier as &$produit) {
            if ($produit['id'] == $idProduitPromo) {
                $prixOriginal = floatval($produit['prix']);
                $nouveauPrix = $prixOriginal - ($prixOriginal * ($reduction / 100));
                $produit['prix'] = $nouveauPrix;
                $produit['prix_total'] = $nouveauPrix * intval($produit['quantite']);
                $produitMisAJour = true;
            }
        }

        if ($produitMisAJour) {
            return $this->respond([
                'message' => 'Code promotionnel appliqué avec succès',
                'promotion' => $promotion,
                'panier' => $panier
            ]);
        } else {
            return $this->failNotFound('Le code promotionnel n’est valable pour aucun produit du panier');
        }
    }
}

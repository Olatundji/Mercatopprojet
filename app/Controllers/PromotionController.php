<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\PromotionModel;
use App\Models\CategoriePromotionModel;
use App\Models\ProductModel;

class PromotionController extends ResourceController
{
    protected $modelName = 'App\Models\PromotionModel';
    protected $format    = 'json';
    protected $produitModel;

    private $categoriePromotionModel;

    public function __construct()
    {
        $this->produitModel = new ProductModel();
        $this->categoriePromotionModel = new CategoriePromotionModel;
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
    { {
            if (!$this->validate($this->categoriePromotionModel->validationRules)) {
                // Si la validation échoue, renvoyer les erreurs de validation
                return $this->failValidationErrors($this->validator->getErrors());
            }
            // Récupérer les données envoyées dans la requête
            $data = [
                'code' => $this->request->getVar('code'),
                'reduction' => $this->request->getVar('reduction'),
                'date_debut' => $this->request->getVar('date_debut'),
                'date_fin' => $this->request->getVar('date_fin'),
                'idCategorie' => $this->request->getVar('idCategorie'),


            ];

            // Insérer le nouveau produit dans la base de données
            $this->categoriePromotionModel->insert($data);

            return $this->respond(['message' => 'Marque created successfully']);
        }
    }

    public function createMontantPromotion()
    {
        $data = $this->request->getVar();

        if (!$this->validate([
            'code'       => 'required',
            'reduction'  => 'required',
            'date_debut' => 'required|valid_date',
            'date_fin'   => 'required|valid_date',
            'montant'  => 'required|is_natural_no_zero',
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

        if (!is_array($panier)) {
            return $this->failValidationError('Le panier doit être un tableau');
        }

        if (empty($code)) {
            return $this->failValidationErrors(['code' => 'Un code promotionnel est requis']);
        }

        if (empty($idUser)) {
            return $this->failValidationErrors(['idUser' => 'L’identifiant utilisateur est requis']);
        }

        if (empty($panier)) {
            return $this->failValidationErrors(['panier' => 'Panier est obligatoire']);
        }

        log_message('debug', 'usePromoCode: Checking code - ' . $code);
        $promotion = $this->model->isValidPromotion($code);

        if ($promotion) {
            log_message('debug', 'usePromoCode: Valid promotion found - ' . print_r($promotion, true));
            $totalReduction = 0;
            $updatedPanier = [];

            foreach ($panier as $item) {
                if (isset($item['idProduit']) && !empty($promotion['idProduit']) && $promotion['idProduit'] == $item['idProduit']) {
                    $item = $this->applyPromotionToProduct($promotion, $item);
                } elseif (isset($item['idCategorie']) && !empty($promotion['idCategorie']) && $promotion['idCategorie'] == $item['idCategorie']) {
                    $item = $this->applyPromotionToCategory($promotion, $item);
                } elseif (!empty($promotion['montant'])) {
                    $item = $this->applyPromotionToMontant($promotion, $item);
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
            log_message('debug', 'usePromoCode: No valid promotion found');
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
        $nouveauPrix = $prixOriginal - ($prixOriginal * ($reduction / 100));
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
        $nouveauPrix = $prixOriginal - ($prixOriginal * ($reduction / 100));
        $item['prix'] = $nouveauPrix;
        $item['reduction'] = ($prixOriginal - $nouveauPrix) * $item['quantite'];
        $item['prixOriginal'] = $prixOriginal;

        return $item;
    }

    private function applyPromotionToMontant($promotion, $totalPanier)
    {
        $montantReduction = 0;
        if ($totalPanier >= $promotion['montant']) {
            $montantReduction = $totalPanier * ($promotion['reduction'] / 100);
            $totalPanier -= $montantReduction;
        }
        return [$totalPanier, $montantReduction];
    }
}

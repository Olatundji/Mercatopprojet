<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\PromotionModel;
use App\Models\CategoriePromotionModel;
use App\Models\ProductModel;
use App\Models\CategorieModel;


class PromotionController extends ResourceController
{
    protected $modelName = 'App\Models\PromotionModel';
    protected $produitModel;
    private $categoriePromotionModel;
    private $categorieModel;


    public function __construct()
    {
        $this->produitModel = new ProductModel();
        $this->categoriePromotionModel = new CategoriePromotionModel();
        $this->categorieModel = new CategorieModel();
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
    public function createCategoryPromotion()
    {
        $data = $this->request->getVar();

        if (!$this->validate([
            'code'       => 'required',
            'reduction'  => 'required',
            'date_debut' => 'required|valid_date',
            'date_fin'   => 'required|valid_date',
            'idCategorie'  => 'required|is_natural_no_zero',
        ])) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        if ($this->model->save($data)) {
            return $this->respondCreated(['message' => 'Promotion créée avec succès']);
        } else {
            return $this->failServerError('Échec de la création de la promotion');
        }
    }
    private function applyPromotionToProduct($promotion, $item)
    {
        if ($promotion['idProduit'] != $item['id']) {
            return $item;
        }

        $reduction = floatval($promotion['reduction']);
        $prixOriginal = floatval($item['prix']);
        $nouveauPrix = $prixOriginal - ($prixOriginal * ($reduction / 100));
        $item['prix'] = $nouveauPrix;

        if (isset($item['quatite'])) {
            $item['total'] = $nouveauPrix * $item['quatite'];
            $item['reduction'] = ($prixOriginal - $nouveauPrix) * $item['quatite'];
        } else {
            $item['total'] = $nouveauPrix;
            $item['reduction'] = $prixOriginal - $nouveauPrix;
        }

        $item['prixOriginal'] = $prixOriginal;

        return $item;
    }

    private function applyPromotionToCategory($promotion, $item)
    {
        $categorieId = $item['categorie']['id'];

        if ($promotion['idCategorie'] != $categorieId) {
            return $item;
        }

        $reduction = floatval($promotion['reduction']);
        $prixOriginal = floatval($item['prix']);
        $nouveauPrix = $prixOriginal - ($prixOriginal * ($reduction / 100));
        $item['prix'] = $nouveauPrix;

        if (isset($item['quatite'])) {
            $item['total'] = $nouveauPrix * $item['quatite'];
            $item['reduction'] = ($prixOriginal - $nouveauPrix) * $item['quatite'];
        } else {
            $item['total'] = $nouveauPrix;
            $item['reduction'] = $prixOriginal - $nouveauPrix;
        }

        $item['prixOriginal'] = $prixOriginal;

        return $item;
    }

    private function applyPromotionToMontant($promotion, $totalPanier)
    {
        if ($totalPanier >= floatval($promotion['montant'])) {
            $totalPanier -= $totalPanier * (floatval($promotion['reduction']) / 100);
        }
        return $totalPanier;
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

        $panier = json_decode(json_encode($panier), true);

        log_message('debug', 'usePromoCode: Checking code - ' . $code);
        $promotion = $this->model->isValidPromotion($code);

        if ($promotion) {
            log_message('debug', 'usePromoCode: Valid promotion found - ' . print_r($promotion, true));
            $totalReduction = 0;
            $updatedPanier = [];

            foreach ($panier as $item) {
                if (isset($item['id']) && !empty($promotion['idProduit']) && $promotion['idProduit'] == $item['id']) {
                    $item = $this->applyPromotionToProduct($promotion, $item);
                } elseif (isset($item['categorie']['id']) && !empty($promotion['idCategorie']) && $promotion['idCategorie'] == $item['categorie']['id']) {
                    $item = $this->applyPromotionToCategory($promotion, $item);
                }
                $updatedPanier[] = $item;
                $totalReduction += $item['reduction'] ?? 0;
            }

            $totalPanier = array_reduce($updatedPanier, function ($carry, $item) {
                return $carry + $item['total'];
            }, 0);
            if (!empty($promotion['montant'])) {
                $totalPanier = $this->applyPromotionToMontant($promotion, $totalPanier);
            }
            return $this->respond([
                'message' => 'Code promotionnel appliqué avec succès',
                'promotion' => $promotion,
                'updatedPanier' => $updatedPanier,
                'totalPanier' => $totalPanier
            ]);
        } else {
            log_message('debug', 'usePromoCode: No valid promotion found');
            return $this->failNotFound('Le code promotionnel n’est pas valide ou a expiré');
        }
    }

    public function deletePromotion($id = null)
    {
        if ($id === null) {
            return $this->failValidationError('L\'ID de la promotion est requis');
        }

        $promotion = $this->model->find($id);

        if (!$promotion) {
            return $this->failNotFound('Promotion non trouvée');
        }

        if ($this->model->delete($id)) {
            return $this->respondDeleted(['message' => 'Promotion supprimée avec succès']);
        } else {
            return $this->failServerError('Échec de la suppression de la promotion');
        }
    }

    public function getAllPromotions()
    {
        $promotions = $this->model->findAll();

        if (!$promotions) {
            return $this->failNotFound('Aucun code promotionnel trouvé');
        }

        $result = [];

        foreach ($promotions as $promotion) {
            $promoDetails = [
                'code' => $promotion['code'],
                'date_debut' => $promotion['date_debut'],
                'date_fin' => $promotion['date_fin'],
                'reduction' => $promotion['reduction'],
            ];

            if (!empty($promotion['idProduit'])) {
                $product = $this->produitModel->find($promotion['idProduit']);
                $promoDetails['type'] = 'Produit';
                $promoDetails['nom'] = $product['nom'] ?? 'Produit inconnu';
            } elseif (!empty($promotion['idCategorie'])) {
                $category = $this->categorieModel->find($promotion['idCategorie']);
                $promoDetails['type'] = 'Categorie';
                $promoDetails['libelle'] = $category['libelle'] ?? 'Catégorie inconnue';
            } elseif (!empty($promotion['montant'])) {
                $promoDetails['type'] = 'Montant';
                $promoDetails['montant'] = $promotion['montant'];
            }

            $result[] = $promoDetails;
        }

        return $this->respond($result);
    }
}

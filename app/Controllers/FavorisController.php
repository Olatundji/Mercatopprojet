<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\FavorisModel;

class FavorisController extends BaseController
{
    use ResponseTrait;

    private $favorisModel;

    public function __construct()
    {
        $this->favorisModel = new FavorisModel();
    }
    public function index()
{
    // Récupérer la page actuelle à partir de la requête GET
    $page = $this->request->getVar('page') ?? 1;

    // Définir le nombre d'éléments par page
    $perPage = 10;

    // Récupérer tous les produits depuis la base de données avec les détails de la marque et de la catégorie
    $favoris = $this->favorisModel
                    ->select('favoris.*, produit.nom as produit_nom, users.nom as user_nom')
                    ->join('produit', 'produit.id = favoris.idProduit')
                    ->join('users', 'users.id = favoris.idUser')
                    ->paginate($perPage, 'default', $page);

    // Vérifier s'il y a des produits
    if (empty($favoris)) {
        // Aucun produit trouvé
        return $this->respond(['message' => 'No favoris found'], 404);
    }

    // Formatter la réponse avec les détails de la marque et de la catégorie
    $formattedFavoris = [];
    foreach ($favoris as $favori) {
        $formattedFavoris[] = [
            'id' => $favori['id'],
            'nom' => $favori['libelle'],
            'produit' => [
                'id' => $favori['idProduit'],
                'nom' => $favori['produit_nom']
            ],
            'user' => [
                'id' => $favori['idUser'],
                'nom' => $favori['user_nom']
            ]
        ];
    }

    // Retourner la liste des produits formatés avec les détails de la marque et de la catégorie
    return $this->respond($formattedFavoris);
}



public function create()
{
    // Valider les données soumises
    if (!$this->validate($this->favorisModel->validationRules)) {
        // Si la validation échoue, renvoyer les erreurs de validation
        return $this->failValidationErrors($this->validator->getErrors());
    }

    // Les données sont valides, continuez le traitement
    // Récupérer les données envoyées dans la requête
    $data = [
        'idProduit' => $this->request->getVar('idProduit'),
        'idUser' => $this->request->getVar('idUser'),
    ];

    // Afficher les données soumises pour déboguer
    //var_dump($data);

    // Insérer le nouveau produit dans la base de données
    $this->favorisModel->insert($data);

    return $this->respond(['message' => 'favoris created successfully']);
}


    public function update($id)
    {
        // Récupérer les données envoyées dans la requête
        $data = [
            'idProduit' => $this->request->getVar('idProduit'),
            'idUser' => $this->request->getVar('idUser'),
        ];

        // Mettre à jour le produit dans la base de données
        $this->favorisModel->update($id, $data);

        return $this->respond(['message' => 'favoris updated successfully']);
    }

    public function delete($id)
    {
        // Supprimer le produit de la base de données
        $this->favorisModel->delete($id);

        return $this->respondDeleted(['message' => 'favoris deleted successfully']);
    }
   
}

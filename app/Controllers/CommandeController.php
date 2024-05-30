<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\CommandeModel;
use App\Models\CommandeProduitModel;
use Exception;



use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class CommandeController extends BaseController
{
    use ResponseTrait;

    private $commandeModel;
    private $commandeProduitModel;


    public function __construct()
    {
        $this->commandeModel = new CommandeModel();
        $this->commandeProduitModel = new CommandeProduitModel();
    }


    public function create()
    {
        $idUser = $this->request->getVar('idUser');
        $panier = $this->request->getVar('panier');

        $transactionId = $this->request->getVar('transaction');
        $methodePay = $this->request->getVar('method_pay');

        // if (!$this->isTransactionValid($transactionId, $methodePay)) {
        //     return $this->fail('La validation du paiement a échoué', 400);
        // }

        $data = [
            'etat' => 'pending',
            'date' => date('Y-m-d H:i:s'),
            'transaction' => $this->request->getVar('transaction'),
            'method_pay' => $this->request->getVar('method_pay'),
            'montant' => $this->request->getVar('montant'),
            'idUser' => $this->request->getVar('idUser')
        ];

        $commandeData = [
            'etat' => 'pending',
            'date' => date('Y-m-d H:i:s'),
            'transaction' => $transactionId,
            'methode_pay' => $methodePay,
            'montant' => $this->request->getVar('montant'),
            'idUser' => $idUser,
        ];


        try {

            $this->commandeModel->insert($data);
            $commande_id = $this->commandeModel->insertID;
        } catch (Exception $e) {
            return $this->fail('Erreur lors de la création de la commande', 500);
        }



        foreach ($panier as $produit) {
            $data = [
                'produit_id' => $produit->id,
                'quantite' => $produit->quatite,
                'commande_id' =>  $commande_id,
            ];

            $this->commandeProduitModel->insert($data);
        }

        return $this->respond(['message' => 'Commande créée avec succès']);
    }


    private function isTransactionValid($transactionId, $methodePay)
    {
        switch ($methodePay) {
            case 'Paypal':
                return $this->validatePaypalTransaction($transactionId);
            case 'Stripe':
                return $this->validateStripeTransaction($transactionId);
                // case 'Kkiapay':
                //     return $this->validateKkiapayTransaction($transactionId);
                // case 'feexpay':
                //     return $this->validateFeexpayTransaction($transactionId);
            default:
                return false;
        }
    }

    private function validatePaypalTransaction($transactionId)
    {
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                getenv('AeFGhGeO4unjO0Zgk4YfWVc_Q43kIgRmgYoI2UHLbd1C7FOzbhlcGe08nswsHcvrsFgEhzIAJuu_cu3L'),     // ClientID
                getenv('EChsBhmeJtASoBqcCa2kVyPHjId9e5r1Tr07VVuLtai5FXu3w98rtbZEQeD8qhI4yWMM4Ibq3D3LacD5')      // ClientSecret
            )
        );

        try {
            $payment = \PayPal\Api\Payment::get($transactionId, $apiContext);
            log_message('info', 'PayPal API response: ' . json_encode($payment));

            if ($payment->getState() == 'approved') {
                return true;
            }
        } catch (\PayPal\Exception\PayPalConnectionException $e) {
            log_message('error', 'Erreur de validation de transaction PayPal: ' . $e->getData());
        } catch (\Exception $e) {
            log_message('error', 'Erreur de validation de transaction PayPal: ' . $e->getMessage());
        }

        return false;
    }




    private function validateStripeTransaction($transactionId)
    {
        \Stripe\Stripe::setApiKey(getenv('sk_test_51PLmtfFeHRORwEaRimbS1JizwSwVc2MYNPiOH6m4h1HBIa8xEWObEnxhVqk73D7yOt83MBPdQFOxBS17cVPgbs1g00JRWiNu5D'));

        try {
            $charge = \Stripe\Charge::retrieve($transactionId);
            log_message('info', 'Stripe API response: ' . json_encode($charge));

            if ($charge->status == 'succeeded') {
                return true;
            }
        } catch (\Stripe\Exception\ApiErrorException $e) {
            log_message('error', 'Erreur de validation de transaction Stripe: ' . $e->getMessage());
        } catch (\Exception $e) {
            log_message('error', 'Erreur de validation de transaction Stripe: ' . $e->getMessage());
        }

        return false;
    }

    private function validateKiapayTransaction($transactionId)
    {
        // $client = new Client();
        // $url = 'https://api.kiapay.com/v1/transactions/' . $transactionId;

        // try {
        //     $response = $client->request('GET', $url, [
        //         'headers' => [
        //             'Content-Type' => 'application/json',
        //         ],
        //     ]);

        //     if ($response->getStatusCode() == 200) {
        //         $transactionData = json_decode($response->getBody(), true);
        //         if (isset($transactionData['status']) && $transactionData['status'] == 'successful') {
        //             return true;
        //         }
        //     }
        // } catch (\Exception $e) {
        //     log_message('error', 'Erreur de validation de transaction kiapay: ' . $e->getMessage());
        // }

        // return false;

        $public_key = "8276f590733111eea6c35d3a0ec50887";
        $private_key = "tpk_8276f592733111eea6c35d3a0ec50887";
        $secret = "tsk_82771ca0733111eea6c35d3a0ec50887";


        $kkiapay = new \Kkiapay\Kkiapay($public_key, $private_key, $secret, $sandbox = true);
        $kkiapay->verifyTransaction($transactionId);

        // il faut voir ce que retourne la fonction (il doit y avoir 
        // un status ou queslque chose qui y ressemble)

        return true;
    }

    // public function validateTransaction($transactionId)
    // {
    //     // Initialisez le client Feexpay avec vos informations d'authentification
    //     $feexpayClient = new Client([
    //         'clientId' => 'VOTRE_CLIENT_ID',
    //         'clientSecret' => 'VOTRE_CLIENT_SECRET',
    //         'baseUrl' => 'https://api.feexpay.com/v1', // L'URL de base de l'API Feexpay
    //     ]);

    //     try {
    //         $transaction = $feexpayClient->transactions->retrieve($transactionId);

    //         // Vérifiez si la transaction est réussie
    //         if ($transaction['status'] === 'success') {
    //             return true; // La transaction est valide
    //         } else {
    //             return false; // La transaction a échoué
    //         }
    //     } catch (ApiErrorException $e) {
    //         log_message('error', 'Erreur de validation de transaction Feexpay: ' . $e->getMessage());
    //         return false; 
    //     } catch (\Exception $e) {
    //         log_message('error', 'Erreur de validation de transaction Feexpay: ' . $e->getMessage());
    //         return false; 
    //     }
    // }

    public function commandesUtilisateur($idUser)
    {
        $commandesUtilisateur = $this->commandeModel->where('idUser', $idUser)->findAll();

        if (empty($commandesUtilisateur)) {
            return $this->failNotFound('No commandes found for this user');
        }

        foreach ($commandesUtilisateur as &$commande) {
            $commande['produit'] = json_decode($commande['produit'], true);
        }

        return $this->respond($commandesUtilisateur);
    }

    public function validerCommande($id)
    {
        $data = ['etat' => 'validated'];
        $this->commandeModel->update($id, $data);

        return $this->respond(['message' => 'Commande validée avec succès']);
    }

    public function update($id)
    {
        $commande = $this->commandeModel->find($id);
        if (!$commande) {
            return $this->failNotFound('Commande not found');
        }

        $data = $this->request->getRawInput();
        $data = array_filter($data, function ($value) {
            return $value !== null && $value !== '';
        });

        $data['updated_at'] = date('Y-m-d H:i:s');

        $this->commandeModel->update($id, $data);

        $updatedCommande = $this->commandeModel->find($id);

        return $this->respond(['message' => 'Commande information updated successfully', 'commande' => $updatedCommande]);
    }
    public function listeToutesCommandes()
    {
        // Récupérer toutes les commandes
        $commandes = $this->commandeModel->findAll();

        if (empty($commandes)) {
            return $this->failNotFound('No commandes found');
        }

        // Inclure les produits de chaque commande et les informations de l'utilisateur
        foreach ($commandes as &$commande) {
            // Récupérer les produits de la commande
            $produitsCommande = $this->commandeProduitModel
                ->select('produit.nom AS nom_produit, commandeproduit.quantite AS quantite_produit')
                ->join('produit', 'produit.id = commandeproduit.produit_id')
                ->where('commandeproduit.commande_id', $commande['id'])
                ->findAll();

            $commande['produits'] = $produitsCommande;

            $userModel = new \App\Models\UserModel();
            $user = $userModel->find($commande['idUser']);

            if ($user) {
                $commande['nom'] = $user['nom'];
            } else {
                $commande['nom'] = 'Unknown User';
            }
        }

        return $this->respond($commandes);
    }


    public function listeCommandesUtilisateur($idUser)
    {
        $commandesUtilisateur = $this->commandeModel->where('idUser', $idUser)->findAll();

        if (empty($commandesUtilisateur)) {
            return $this->failNotFound('No commandes found for this user');
        }

        foreach ($commandesUtilisateur as &$commande) {
            $produitsCommande = $this->commandeProduitModel
                ->select('produit.nom AS nom_produit, commandeproduit.quantite AS quantite_produit')
                ->where('commandeproduit.commande_id', $commande['id'])
                ->join('produit', 'produit.id = commandeproduit.produit_id')
                ->findAll();

            $commande['produits'] = $produitsCommande;
        }

        return $this->respond($commandesUtilisateur);
    }
}

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
                getenv('PAYPAL_CLIENT_ID'),     // ClientID
                getenv('PAYPAL_SECRET')      // ClientSecret
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
        \Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));

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

    // private function validateKkiapayTransaction($transactionId)
    // {
    //     \KKiaPay\KKiaPay::setApiKey(getenv('KKIAPAY_SECRET_KEY'));

    //     try {
    //         $transaction = \KKiaPay\Transaction::retrieve($transactionId);
    //         log_message('info', 'KKiaPay API response: ' . json_encode($transaction));

    //         if ($transaction->status == 'success') {
    //             return true;
    //         }
    //     } catch (\KKiaPay\Exception\ApiErrorException $e) {
    //         log_message('error', 'Erreur de validation de transaction KKiaPay: ' . $e->getMessage());
    //     } catch (\Exception $e) {
    //         log_message('error', 'Erreur de validation de transaction KKiaPay: ' . $e->getMessage());
    //     }

    //     return false;
    // }

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
        $commandes = $this->commandeModel->findAll();

        if (empty($commandes)) {
            return $this->failNotFound('Aucune commande trouvée');
        }

        return $this->respond($commandes);
    }

    public function listeCommandesUtilisateur($idUser)
    {
        $commandes = $this->commandeModel->where('idUser', $idUser)->findAll();

        if (empty($commandes)) {
            return $this->failNotFound('Aucune commande trouvée pour cet utilisateur');
        }

        return $this->respond($commandes);
    }
}

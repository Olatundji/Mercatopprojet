<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\CommandeModel;
use GuzzleHttp\Client;

class CommandeController extends BaseController
{
    use ResponseTrait;

    private $commandeModel;

    public function __construct()
    {
        $this->commandeModel = new CommandeModel();
    }

    public function search()
    {
        $keyword = $this->request->getGet('keyword');
        $results = $this->commandeModel->searchCommandes($keyword);
        return $this->respond($results);
    }

    public function index()
    {
        $commandes = $this->commandeModel->findAll();

        if (empty($commandes)) {
            return $this->failNotFound('No commandes found');
        }

        return $this->respond($commandes);
    }

    public function create()
    {
        $data = [
            'etat' => 'pending',
            'date' => date('Y-m-d H:i:s'),
            'transaction' => $this->request->getVar('transaction'),
            'methode_pay' => $this->request->getVar('methode_pay'),
            'montant' => $this->request->getVar('montant'),
            'produits' => $this->request->getVar('panier'),
            'idUser' => $this->request->getVar('idUser'),
        ];

        if (!$this->isTransactionValid($data['transaction'], $data['methode_pay'])) {
            return $this->fail('Transaction ID is not valid', 400);
        }

        $this->commandeModel->insert($data);

        return $this->respond(['message' => 'Commande created successfully']);
    }

    private function isTransactionValid($transactionId, $methodePay)
    {
        switch ($methodePay) {
            case 'paypal':
                return $this->validatePaypalTransaction($transactionId);
            case 'stripe':
                return $this->validateStripeTransaction($transactionId);
            case 'kiapay':
                return $this->validateKiapayTransaction($transactionId);
            case 'fedapay':
                return $this->validateFedapayTransaction($transactionId);
            default:
                return false;
        }
    }

    private function validatePaypalTransaction($transactionId)
    {
        $client = new Client();
        $url = 'https://api.sandbox.paypal.com/v1/payments/payment/' . $transactionId;

        $clientId = 'your_paypal_client_id';
        $clientSecret = 'your_paypal_client_secret';

        try {
            $response = $client->request('GET', $url, [
                'auth' => [$clientId, $clientSecret],
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ]);

            if ($response->getStatusCode() == 200) {
                $transactionData = json_decode($response->getBody(), true);
                if (isset($transactionData['state']) && $transactionData['state'] == 'approved') {
                    return true;
                }
            }
        } catch (\Exception $e) {
            log_message('error', 'Erreur de validation de transaction PayPal: ' . $e->getMessage());
        }

        return false;
    }

    private function validateStripeTransaction($transactionId)
    {
        $client = new Client();
        $url = 'https://api.stripe.com/v1/charges/' . $transactionId;

        $apiKey = 'your_stripe_api_key';

        try {
            $response = $client->request('GET', $url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ],
            ]);

            if ($response->getStatusCode() == 200) {
                $transactionData = json_decode($response->getBody(), true);
                if (isset($transactionData['status']) && $transactionData['status'] == 'succeeded') {
                    return true;
                }
            }
        } catch (\Exception $e) {
            log_message('error', 'Erreur de validation de transaction Stripe: ' . $e->getMessage());
        }

        return false;
    }

    private function validateKiapayTransaction($transactionId)
    {
        $client = new Client();
        $url = 'https://api.kiapay.com/v1/transactions/' . $transactionId;

        $apiKey = '8276f590733111eea6c35d3a0ec50887';

        try {
            $response = $client->request('GET', $url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ],
            ]);

            if ($response->getStatusCode() == 200) {
                $transactionData = json_decode($response->getBody(), true);
                if (isset($transactionData['status']) && $transactionData['status'] == 'successful') {
                    return true;
                }
            }
        } catch (\Exception $e) {
            log_message('error', 'Erreur de validation de transaction kiapay: ' . $e->getMessage());
        }

        return false;
    }

    private function validateFedapayTransaction($transactionId)
    {
        $client = new Client();
        $url = 'https://api.fedapay.com/v1/transactions/' . $transactionId;

        $apiKey = 'your_fedapay_api_key';

        try {
            $response = $client->request('GET', $url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Accept' => 'application/json',
                ],
            ]);

            if ($response->getStatusCode() == 200) {
                $transactionData = json_decode($response->getBody(), true);
                if (isset($transactionData['status']) && $transactionData['status'] == 'approved') {
                    return true;
                }
            }
        } catch (\Exception $e) {
            log_message('error', 'Erreur de validation de transaction FedaPay: ' . $e->getMessage());
        }

        return false;
    }

    public function commandesUtilisateur($idUser)
    {
        $commandesUtilisateur = $this->commandeModel->where('idUser', $idUser)->findAll();

        if (empty($commandesUtilisateur)) {
            return $this->failNotFound('No commandes found for this user');
        }

        return $this->respond($commandesUtilisateur);
    }

    public function validerCommande($id)
    {
        $data = ['etat' => 'validated'];
        $this->commandeModel->update($id, $data);

        return $this->respond(['message' => 'Commande validée avec succès']);
    }
}

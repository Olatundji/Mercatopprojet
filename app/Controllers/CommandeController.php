<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\CommandeModel;
use App\Models\CommandeProduitModel;


use GuzzleHttp\Client;

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
        $methodePay = $this->request->getVar('methode_pay');

        if (!$this->isTransactionValid($transactionId, $methodePay)) {
            return $this->fail('La validation du paiement a échoué', 400);
        }

        $commandeData = [
            'etat' => 'pending',
            'date' => date('Y-m-d H:i:s'),
            'transaction' => $transactionId,
            'methode_pay' => $methodePay,
            'montant' => $this->request->getVar('montant'),
            'idUser' => $idUser,
        ];

        $commandeId = $this->commandeModel->insert($commandeData);

        if (!$commandeId) {
            return $this->fail('Erreur lors de la création de la commande', 500);
        }

        foreach ($panier as $produit) {
            $produitId = $produit['produit_id'];
            $quantite = $produit['quantite'];

            $commandeProduitData = [
                'commande_id' => $commandeId,
                'produit_id' => $produitId,
                'quantite' => $quantite,
            ];

            $this->commandeProduitModel->insert($commandeProduitData);
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
            case 'Kkiapay':
                return $this->validateKiapayTransaction($transactionId);
            case 'fedapay':
                return $this->validateFexpayTransaction($transactionId);
            default:
                return false;
        }
    }

    private function validatePaypalTransaction($transactionId)
    {
        $client = new Client();
        $url = 'https://api.sandbox.paypal.com/v1/payments/payment/' . $transactionId;

        try {
            $response = $client->request('GET', $url, [
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

        try {
            $response = $client->request('GET', $url, [
                'headers' => [
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

        try {
            $response = $client->request('GET', $url, [
                'headers' => [
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

    private function validateFexpayTransaction($transactionId)
    {
        $client = new Client();
        $url = 'https://api.fexpay.com/v1/transactions/' . $transactionId;

        try {
            $response = $client->request('GET', $url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ]);

            if ($response->getStatusCode() == 200) {
                $transactionData = json_decode($response->getBody(), true);
                if (isset($transactionData['status']) && $transactionData['status'] == 'success') {
                    return true;
                }
            }
        } catch (\Exception $e) {
            log_message('error', 'Erreur de validation de transaction Fexpay: ' . $e->getMessage());
        }

        return false;
    }


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
}

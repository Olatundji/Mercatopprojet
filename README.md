# Mercatopprojet
e-commerce

paiement avec stripe
npm install @vue-stripe/vue-stripe

Paypal
https://developer.paypal.com/api/rest/

KkiaPay using docs (explixite)

vérification d'une transaction en back

FeexPay docs (explixite)

TODO : {
    - favoris --
    - boutique ---
    - processus de paiement avec Paypal et Kkyapay
    - rechercher un produit par nom, categorie et marque
    - blog
}


        $public_key = "8276f590733111eea6c35d3a0ec50887";
        $private_key = "tpk_8276f592733111eea6c35d3a0ec50887";
        $secret = "tsk_82771ca0733111eea6c35d3a0ec50887";

        try {
            $kkiapay = new \Kkiapay\Kkiapay($public_key, $private_key, $secret, $sandbox = true);
            $kkiapay->verifyTransaction($transactionId);
        } catch (Exceptio $e) {
            return false; 
            log_message('error', 'Erreur de validation de transaction kiapay: ' . $e->getMessage());
        }

        return true;


$2y$10$z2tNeBrJh33u1cJ0oxCn0uVQQel9A4frqUwsvSrewSHXYUaFE9AHG

$2y$10$z2tNeBrJh33u1cJ0oxCn0uVQQel9A4frqUwsvSrewSHXYUaFE9AHG
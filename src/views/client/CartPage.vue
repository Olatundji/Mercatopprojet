<template>
    <div v-if="isModalOpen" class="modal-custom" @click="closeModalOutside">
        <div class="modal-content">
            <span class="close" @click="closeModal">&times;</span>
            <h2>Chossisez un moyen de paiement</h2>
            <div class="checkout shopping">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="block billing-details">
                                <h4 class="widget-title">Moyen de paiement</h4>
                                <div v-for="category in paymentCategories" :key="category.name">
                                    <div class="payment-category">
                                        <div id="render" class="category-header">
                                            <h3>{{ category.name }}</h3>
                                            <input type="radio" :id="category.name" :value="category.name"
                                                v-model="selectedPayment" />
                                        </div>
                                    </div>
                                </div>

                                <button @click.prevent="pay" :disabled="!selectedPayment">Payer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div v-if="showPaypalButton" class="modal-custom" @click="closeModalOutside">
        <div class="modal-content">
            <span class="close" @click="closeModal">&times;</span>
            <h2>Paimement avec paypal</h2>
            <div class="checkout shopping">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="block billing-details">
                                <div id="paypal-button-container"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="render"></div>

    <TheHeader></TheHeader>
    <CRow>
        <CCol class="mx-3" :md="6">
            <h3>Ajouter un code promo</h3>
            <input class="form-control mb-3 " v-model="promo" type="text">
            <span class="erreur" v-if="error != null"> {{ error }} </span><br>
            <button @click="applyCode" class="btn btn-success text-white ">Appliquer</button>
        </CCol>
    </CRow>
    <div class="page-wrapper">
        <div class="cart shopping">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="block">
                            <div class="product-list">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Aperçu de l'article</th>
                                            <th>Prix</th>
                                            <th>Quantité</th>
                                            <th>Total</th>
                                            <th>Marque</th>
                                            <th>Catégorie</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in cart" :key="index">
                                            <td>
                                                <div class="product-info">
                                                    <img width="80" :src="item.image" alt="" />
                                                    <a href="#!">{{ item.nom }}</a>
                                                </div>
                                            </td>
                                            <td>XOF {{ item.prix }}</td>
                                            <td>
                                                <input type="number" v-model.number="item.quantite" placeholder="1"
                                                    :min="1" :max="item.qte" @input="validateQuantity(item)" />
                                            </td>
                                            <td>XOF {{ item.total }}</td>
                                            <td>{{ item.marque.nom }}</td>
                                            <td>{{ item.categorie.nom }}</td>
                                            <td>
                                                <a @click.prevent="removeFromCart(item.id)" class="product-remove"
                                                    href="#">Supprimer</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <h3 class="pull-right espace">
                                    Total du panier : XOF {{ montant_total }}
                                </h3>
                                <div class="go-right">
                                    <h6>
                                        Montant après la réduction : XOF {{ nouveau_total }}
                                    </h6>
                                </div>
                                <button @click="valider" class="btn btn-success pull-right" type="submit">
                                    Valider
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <TheFooter></TheFooter>
</template>

<script>
import TheHeader from '@/components/client/TheHeader.vue'
import TheFooter from '@/components/client/TheFooter.vue'
import store from '@/store'
import { openKkiapayWidget, addKkiapayListener, removeKkiapayListener, } from "kkiapay";
import { loadScript } from '@paypal/paypal-js';
import { commande, promotion } from '../../services';
import router from '../../router'
import 'https://api.feexpay.me/feexpay-javascript-sdk/index.js'

export default {
    name: 'CartPage',
    components: {
        TheFooter,
        TheHeader,
    },
    beforeUnmount() {
        removeKkiapayListener('success', this.successHandler)
    },
    computed: {
        cart() {
            return store.getters.getCartList
        },

    },
    data() {
        return {
            stripe_pk: "pk_test_51PJJQERwkxDsbBGjZeWcxaCCJhXhZwHyylfcKr0KRCHZA5s1l7BiHB0TwzHo2z1DLGFZoEZt75It1twhTF613ba800pC2dKa92",
            stripe_pvk: 'sk_test_51PJJQERwkxDsbBGj0bIgOD936wAJKwlGLSIlnRqU0EEZHGmBYy0z20uyhIkkuS8C9KMebJ6MbgSu7ButwcrwYTGv00Ien6NuCR',
            kkiaypay_pk: '8276f590733111eea6c35d3a0ec50887',
            paypal_client_id: 'AeFGhGeO4unjO0Zgk4YfWVc_Q43kIgRmgYoI2UHLbd1C7FOzbhlcGe08nswsHcvrsFgEhzIAJuu_cu3L',
            feexpay: '',
            successUrl: 'https://mercatop.lemeilleurcointech.com/user/commandes',
            cancelUrl: 'https://mercatop.lemeilleurcointech.com/user/cart',
            loading: false,
            stripe: null,
            showPaypalButton: false,
            user_id: store.getters.getUser?.id ?? 0,
            selectedPayment: null,
            paymentCategories: [
                {
                    name: 'Paypal',
                    isOpen: true,
                    description: ""
                },
                {
                    name: 'Stripe',
                    isOpen: false,
                    description: ""
                },
                {
                    name: 'FeexPay',
                    isOpen: false,
                    description: ""
                },
                {
                    name: 'Kkiapay',
                    isOpen: false,
                    description: ""
                }
            ],
            montant_total: 0,
            nouveau_total: 0,
            isModalOpen: false,
            dollard_prix: 604.65,
            promo: '',
            error: null,
        }
    },
    mounted() {
        addKkiapayListener('success', this.successHandler)
        this.updateMontantTotal();
        this.nouveau_total = this.montant_total
    },

    methods: {
        applyCode() {
            this.error = null
            console.log(this.promo);
            console.log(this.cart);
            promotion.usePromotion(this.promo, this.cart, store.getters.getUser?.id ?? 0).then((response) => {
                console.log(response);
                this.nouveau_total = response.data.totalPanier
            }).catch((error) => {
                this.nouveau_total = this.montant_total
                this.error = error.response.data.messages.error
            })
        },
        async stripePay() {
            const { error } = await this.stripe.redirectToCheckout({
                mode: 'payment',
                lineIitems: this.lineItems,
                successUrl: 'https://votre-site.com/success',
                cancelUrl: 'https://votre-site.com/cancel',
            });
            if (error) {
                console.error(error);
            }
        },
        successHandler(response) {
            console.log(response.transactionId);
            if (response.transactionId) {
                commande.createCommande(response.transactionId, this.selectedPayment,
                    this.montant_total, this.cart, store.getters.getUser.id).then((response) => {
                        if (response.status == 200) {
                            router.push({ name: `UserCommandes` })
                        }
                    }).catch((error) => {
                        console.log(error);
                    })
                this.isModalOpen = false;
            }
        },
        async pay() {
            let paypal;
            switch (this.selectedPayment) {
                case 'Paypal':
                    this.isModalOpen = false
                    try {
                        this.showPaypalButton = !this.showPaypalButton
                        paypal = await loadScript({ clientId: this.paypal_client_id });
                    } catch (error) {
                        console.log("Error de chargement du sdk de paypal");
                    }
                    if (paypal) {
                        try {
                            this.isModalOpen = false
                            await paypal.Buttons({
                                createOrder: (data, actions) => {
                                    return actions.order.create({
                                        purchase_units: [{
                                            amount: {
                                                value: (this.nouveau_total / this.dollard_prix).toFixed(2)
                                            }
                                        }]
                                    })
                                },
                                onApprove: (data, actions) => {
                                    return actions.order.capture().then(details => {
                                        console.log(details);
                                        this.showPaypalButton = false
                                        commande.createCommande(details.id, this.selectedPayment,
                                            this.montant_total, this.cart, this.user_id).then((response) => {
                                                if (response.status == 200) {
                                                    router.push({ name: `UserCommandes` })
                                                }
                                            })

                                    });
                                },
                                onError: (err) => {
                                    console.error('Erreur lors du traitement du paiement PayPal', err);
                                }
                            }).render("#paypal-button-container")
                        } catch (error) {
                            console.log("failed to rendnder button paypal", error);
                        }
                    }
                    break;
                case 'Kkiapay':
                    openKkiapayWidget({
                        amount: this.nouveau_total,
                        api_key: this.kkiaypay_pk,
                        sandbox: true,
                        phone: "97000000",
                    });
                    break;
                case 'FeexPay':
                    console.log(this.selectedPayment);
                    await FeexPayButton.init("render", {
                        id: '648d7a2b72ea51df295a06d4',
                        amount: this.nouveau_total,
                        token: "fp_sZ5RVWy3U0aWhcBh9fteXs3iJUFoERpvXLj8zPcji4jpOcynpNPDvIbqK3hdKRvx",
                        callback: (response) => {
                            if (response.status == 'SUCCESSFUL') {
                                commande.createCommande(response.transaction_id, this.selectedPayment,
                                    this.montant_total, this.cart, store.getters.getUser.id).then((response) => {
                                        if (response.status == 200) {
                                            router.push({ name: `UserCommandes` })
                                        }
                                    }).catch((error) => {
                                        console.log(error);
                                    })
                            } else {
                                console.log(response);
                            }
                        },
                        mode: 'LIVE',
                        custom_button: false,
                        description: "Test",
                    })

                    break;
                case 'Stripe':
                    console.log(this.selectedPayment);
            }
        },
        closeModal() {
            this.isModalOpen = false;
            this.showPaypalButton = false
        },
        valider() {
            if (store.getters.isConnect !== null) {
                this.isModalOpen = true
            } else {
                router.push({ name: `Login` })
            }
        },
        closeModalOutside(event) {
            if (event.target.classList.contains('modal-custom')) {
                this.closeModal();
            }
        },
        onchange(response) {
            console.log(response);
        },
        removeFromCart(id) {
            store.commit('deleteToCart', id);
            this.updateMontantTotal();
        },
        updateTotal(item) {
            item.total = item.prix * item.quantite;
            this.updateMontantTotal();
        },
        updateMontantTotal() {
            if (Array.isArray(this.cart) && this.cart.length > 0) {
                this.montant_total = this.cart.reduce((total, item) => parseInt(total) + parseInt(item.total), 0);
            } else {
                this.montant_total = 0;
            }
            this.nouveau_total = this.montant_total;
        },
        validateQuantity(item) {
            if (item.quantite > item.qte) {
                item.quantite = item.qte;
            } else if (item.quantite < 1) {
                item.quantite = 1;
            }
            this.updateTotal(item);
        }
    }
}
</script>

<style lang="scss" scoped>
.erreur {
    color: red;
}

.payment-category {
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-bottom: 1rem;
}

.category-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem;
    background-color: #f5f5f5;
    cursor: pointer;
}

.modal-custom {
    z-index: 1;
    display: flex;
    position: fixed;
    left: 0;
    top: 0;
    width: 100%;
    height: auto;
    overflow: scroll;
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 30%;
    height: auto;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

.go-right {
    color: green;

}

.espace {
    margin-left: 7px;
}
</style>

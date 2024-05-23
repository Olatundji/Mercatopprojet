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

                                <button @click="pay" :disabled="!selectedPayment">Payer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <TheHeader></TheHeader>
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
                                                    <img width="80" src="@/assets/images/shop/cart/cart-2.jpg" alt="" />
                                                    <a href="#!">{{ item.nom }}</a>
                                                </div>
                                            </td>
                                            <td>XOF {{ item.prix }}</td>
                                            <td>
                                                <input type="number" v-model.number="item.quantite" placeholder="1"
                                                    :min="1" :max="item.qte" @input="updateTotal(item)">
                                            </td>
                                            <td>XOF {{ item.total }}</td>
                                            <td> {{ item.marque.nom }} </td>
                                            <td> {{ item.categorie.nom }} </td>
                                            <td>
                                                <a @click.prevent="removeFromCart(item.id)" class="product-remove"
                                                    href="#">Supprimer</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <h3 class="pull-right espace">Total du panier : XOF {{ montant_total }}</h3>
                                <button @click="valider" class="btn btn-success pull-right"
                                    type="submit">Valider</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <stripe-checkout ref="paymentRef" 
            :pk="pk" 
            mode="payment"
            :line-items="lineItems"
            :successUrl="successUrl"
            :cancelUrl="cancelUrl"
            @loading="v => loading = v "
            >

        </stripe-checkout>
        <button @click="pay">Pay Now</button>
    </div>
    <TheFooter></TheFooter>
</template>

<script>
import TheHeader from '@/components/client/TheHeader.vue'
import TheFooter from '@/components/client/TheFooter.vue'
import store from '@/store'
import { openKkiapayWidget, addKkiapayListener, removeKkiapayListener, } from "kkiapay";

import { StripeCheckout } from '@vue-stripe/vue-stripe';

export default {
    name: 'CartPage',
    components: {
        TheFooter,
        TheHeader,
        StripeCheckout
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
            kkiaypay_pk: '8276f590733111eea6c35d3a0ec50887',
            paypal_pk:'',
            feexpay: '',
            loading: false,
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
            isModalOpen: false,
        }
    },
    mounted() {
        addKkiapayListener('success', this.successHandler)
        this.updateMontantTotal();
    },

    methods: {
        successHandler(response) {
            console.log(response);
        },
        pay() {
            switch (this.selectedPayment) {
                case 'Paypal':
                    console.log(`Paiement avec ${this.selectedPayment}`);
                    break;
                case 'Kkiapay':
                    openKkiapayWidget({
                        amount: this.montant_total,
                        api_key: this.kkiaypay_pk,
                        sandbox: true,
                        phone: "97000000",
                    });
                    break;
                case 'FeexPay':
                    console.log(`Paiement avec ${this.selectedPayment}`)
                    break;
                case 'Stripe':
                    console.log(`Paiement avec ${this.selectedPayment}`)
            }
        },
        closeModal() {
            this.isModalOpen = false;
        },
        valider() {
            this.isModalOpen = true
        },
        closeModalOutside(event) {
            if (event.target.classList.contains('modal-custom')) {
                this.closeModal();
            }
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
            this.montant_total = this.cart.reduce((total, item) => parseInt(total) + parseInt(item.total), 0);
        }
    }
}
</script>

<style lang="scss" scoped>
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

.espace {
    margin-left: 7px;
}
</style>
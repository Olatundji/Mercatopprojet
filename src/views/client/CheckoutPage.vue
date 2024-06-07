<template>
    <TheHeader></TheHeader>
    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <h1 class="page-name">Paiement</h1>
                        <ol class="breadcrumb">
                            <li><a href="index.html">Home</a></li>
                            <li class="active">checkout</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="checkout shopping">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="block billing-details">
                        <h4 class="widget-title">Moyen de paiement</h4>
                        <div v-for="category in paymentCategories" :key="category.name">
                            <div class="payment-category">
                                <div class="category-header" @click="toggleCategory(category.name)">
                                    <h3>{{ category.name }}</h3>
                                    <input type="radio" :id="category.name" :value="category.name" v-model="selectedPayment" />
                                </div>
                            </div>
                        </div>

                        <button @click="goPay" :disabled="!selectedPayment">Payer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <TheFooter></TheFooter>
</template>

<script>
import { openKkiapayWidget } from "kkiapay";
import TheHeader from '@/components/client/TheHeader.vue'
import TheFooter from '@/components/client/TheFooter.vue'

// import 'https://cdn.kkiapay.me/k.js'

export default {

    data() {
        return {
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
            ]
        }
    },
    methods: {
        toggleCategory(categoryName) {
            const category = this.paymentCategories.find(c => c.name === categoryName);
            category.isOpen = !category.isOpen;
        },
        goPay() {
            openKkiapayWidget({
                amount: 4000,
                api_key: "8276f590733111eea6c35d3a0ec50887",
                sandbox: true,
                phone: "97000000",
            });
            console.log(`Paiement avec ${this.selectedPayment}`);
        }
    },
    components: {
        TheFooter, TheHeader
    }

}
</script>

<style scoped>
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

.payment-options {
    padding: 1rem;
}

.payment-option {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
}

.payment-option img {
    height: 24px;
    margin-right: 0.5rem;
}

.payment-option label {
    display: flex;
    align-items: center;
    cursor: pointer;
}
</style>
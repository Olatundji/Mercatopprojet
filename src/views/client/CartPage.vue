<template>
    <TheHeader></TheHeader>
    <div class="page-wrapper">
        <div class="cart shopping">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="block">
                            <div class="product-list">
                                <form method="post">
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
                                                        <img width="80" src="@/assets/images/shop/cart/cart-2.jpg"
                                                            alt="" />
                                                        <a href="#!">{{ item.nom }}</a>
                                                    </div>
                                                </td>
                                                <td>XOF {{ item.prix }}</td>
                                                <td>
                                                    <input type="number" v-model.number="item.quantite" min="1" :max="item.qte"
                                                        @input="updateTotal(item)">
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
                                    <button class="btn btn-main pull-right" type="submit">Valider</button>
                                </form>
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

export default {
    name: 'CartPage',
    components: {
        TheFooter,
        TheHeader
    },
    computed: {
        cart(){
            return store.getters.getCartList
        }
    },
    data() {
        return {
            
        }
    },
    mounted() {
        this.cart = store.getters.getCartList.map(item => {
            return {
                ...item,
                quantite: 1,
                total: item.prix
            }
        });
    },
    methods: {
        removeFromCart(id) {
            store.commit('deleteToCart', id);
        },
        updateTotal(item) {
            item.total = item.prix * item.quantite;
        }
    }
}
</script>

<style lang="scss" scoped></style>
<template>
    <TheHeader></TheHeader>

    <section class="single-product">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <ol class="breadcrumb">
                        <li> <router-link to="/" >Home</router-link> </li>
                        <li>  <router-link to="/produits" >Produits</router-link> </li>
                        <li class="active">Details produit</li>
                    </ol>
                </div>
            </div>
            <div class="row mt-20">
                <div class="col-md-5">
                    <div class="single-product-slider">
                        <div id='carousel-custom' class='carousel slide' data-ride='carousel'>
                            <div class='carousel-outer'>
                                <div class='carousel-inner '>
                                    <div class='item active'>
                                        <img src='@/assets/images/shop/single-products/product-1.jpg' alt=''
                                            data-zoom-image="@/assets/images/shop/single-products/product-1.jpg" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="single-product-details">
                        <h2>{{ produit_nom }}</h2>
                        <p class="product-price"> XOF {{ produit_prix }} </p>
                        <h4 class="mb-4">Description</h4>
                        <p class="product-description mt-20">
                            {{ produit_description }}
                        </p>
                        
                        <div class="product-category">
                            <span>Catégorie </span>
                            <ul>
                                <li><a href="#">{{ produit_categorie_nom }} / {{ produit_marque_nom }} </a></li>
                            </ul>
                        </div>
                        <router-link class="btn btn-main mt-20" to="/user/cart">Ajouter au panier</router-link>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="products related-products section">
        <div class="container">
            <div class="row">
                <div class="title text-center">
                    <h2>Autre produits </h2>
                </div>
            </div>
            <div class="row">
                <div v-for="(item, index) in randomProduits" :key="index" class="col-md-3">
                    <div class="product-item">
                        <div class="product-thumb">
                            <img class="img-responsive" src="@/assets/images/shop/products/product-5.jpg"
                                alt="product-img" />
                            <div class="preview-meta">
                                <ul>
                                    <li>
                                        <span data-toggle="modal" data-target="#product-modal">
                                            <i @click="addToCart(item)" class="tf-ion-android-add"></i>
                                        </span>
                                    </li>
                                    <li>
                                        <a href="#!"><i class="tf-ion-ios-heart"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="product-content">
                            <h4>
                                <router-link @click="goDetails(item.id)" to='/produit/single'>
                                    {{ item.nom }}
                                </router-link>
                            </h4>
                            <p class="price">XOF {{ item.prix }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <TheFooter></TheFooter>
</template>

<script>

import TheHeader from '@/components/client/TheHeader.vue'
import TheFooter from '@/components/client/TheFooter.vue'
import { produit } from '../../services';
import store from '../../store';

export default {
    mounted() {
        produit.showProduit(localStorage.getItem('id_produit')).then((response) => {
            this.produit_id = response.data.id
            this.produit_nom = response.data.nom
            this.produit_description = response.data.description
            this.produit_image = response.data.image
            this.produit_prix = response.data.prix
            this.produit_qte = response.data.qte
            this.produit_categorie_nom = response.data.categorie.nom
            this.produit_marque_nom = response.data.marque.nom
        })

        produit.randomProduit(4).then((response) => {
            this.randomProduits = response.data
        })
    },
    data() {
        return {
            randomProduits: [],
            produit_id: '',
            produit_nom: '',
            produit_description: '',
            produit_image: '',
            produit_prix: '',
            produit_qte: '',
            produit_categorie_nom: '',
            produit_marque_nom: '',
        }
    },
    name: 'DetailsProduit',
    components: {
        TheHeader, TheFooter
    },
    methods: {
        goDetails(id) {
            localStorage.setItem('id_produit', id)
        },
        addToCart(element) {
            store.commit('addToCart', element)
            window.location.reload()
        },
    },
}
</script>

<style scoped></style>
<!-- eslint-disable vue/multi-word-component-names -->

<template>
    <TheHeader/>


    <section class="product-category section" id="marqueSection">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title text-center">
                        <h2>Les marques phares de notre boutique</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="category-box">
                        <a href="#!">
                            <img src="@/assets/images/shop/category/category-1.jpg" alt="" />
                            <div class="content">
                                <h3>Nike</h3>
                                <p>Shop New Season Clothing</p>
                            </div>
                        </a>
                    </div>
                    <div class="category-box">
                        <a href="#!">
                            <img src="@/assets/images/shop/category/category-2.jpg" alt="" />
                            <div class="content">
                                <h3>Adidas</h3>
                                <p>Get Wide Range Selection</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="category-box category-box-2">
                        <a href="#!">
                            <img src="@/assets/images/shop/category/category-3.jpg" alt="" />
                            <div class="content">
                                <h3>Jordan</h3>
                                <p>Special Design Comes First</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="products section bg-gray">
        <div class="container">
            <div class="row">
                <div class="title text-center">
                    <h2>Trendy Products</h2>
                </div>
            </div>
            <div class="row">
                <div v-for="(item, index) in produits" :key="index" class="col-md-4">
                    <div class="product-item">
                        <div class="product-thumb">
                            <img class="img-responsive" :src="item.image"
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

    <TheFooter/>

</template>

<script>

import '@/assets/plugins/jquery/dist/jquery.min.js'
import "@/assets/plugins/bootstrap/js/bootstrap.min.js"
import "@/assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"
import "@/assets/plugins/ekko-lightbox/dist/ekko-lightbox.min.js"
import "@/assets/plugins/syo-timer/build/jquery.syotimer.min.js"
import "@/assets/plugins/slick/slick.min.js"
import "@/assets/plugins/slick/slick-animation.min.js"
import "@/assets/plugins/google-map/gmap.js"
import "@/assets/js/script.js"
import TheFooter from '@/components/client/TheFooter.vue'
import TheHeader from '@/components/client/TheHeader.vue'
import { produit } from '../../services'
import store from '../../store'


export default {
    components: {
        TheFooter, TheHeader
    },
    mounted() {
        produit.randomProduit(9).then((response) => {
            console.log(response);
            this.produits = response.data
        } )
    },
    data() {
        return {
            produits: []
        }
    },
    methods: {
        goDetails(id) {
            localStorage.setItem('id_produit', id)
        },
        addToCart(element) {
            store.commit('addToCart', element)
        },
    },

}
</script>

<style scoped>




a {
    text-decoration: none;
}

</style>
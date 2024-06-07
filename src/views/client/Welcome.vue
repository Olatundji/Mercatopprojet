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
                            <img src="@/assets/images/shop/category/nike-logo.png" alt="" />
                            <div class="content">
                                <h3>Nike</h3>
                                <p>Just Do It</p>
                            </div>
                        </a>
                    </div>
                    <div class="category-box">
                        <a href="#!">
                            <img src="@/assets/images/shop/category/adidas-logo.jpg" alt="" />
                            <div class="content">
                                <h3>Adidas</h3>
                                <p>Impossible is nothing</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="category-box category-box-2">
                        <a href="#!">
                            <img src="@/assets/images/shop/category/jordan-logo.jpg" alt="" />
                            <div class="content">
                                <h3>Jordan</h3>
                                <p>Be Like Mike</p>
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
                    <h2>Quelques produits</h2>
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

    <div class="title text-center">
        <h2>Quelques avis de nos clients</h2>
    </div>
    <div class="comments" >

        <div class="card">
            <div class="profile">
                <img src="@/assets/images/shop/category/nike-logo.png" alt="Profile Image" class="profile-image">
                <div class="profile-info">
                    <h2>Utilisateur 1050</h2>
                </div>
            </div>
            <p class="description">
                It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using...
            </p>
            <p class="date">14 Juin 2024</p>
        </div>

        <div class="card">
            <div class="profile">
                <img src="@/assets/images/shop/category/nike-logo.png" alt="Profile Image" class="profile-image">
                <div class="profile-info">
                    <h2>Utilisateur 5050</h2>
                </div>
            </div>
            <p class="description">
                It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using...
            </p>
            <p class="date">14 Juin 2024</p>
        </div>

        <div class="card">
            <div class="profile">
                <img src="@/assets/images/shop/category/nike-logo.png" alt="Profile Image" class="profile-image">
                <div class="profile-info">
                    <h2>Utilisateur 007</h2>
                </div>
            </div>
            <p class="description">
                It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using...
            </p>
            <p class="date">12 Juin 2024</p>
        </div>
    </div>


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
import TheFooter from '../../components/client/TheFooter.vue'
import TheHeader from '../../components/client/TheHeader.vue'
import { produit } from '../../services'
import store from '../../store'


export default {
    components: {
        TheFooter, TheHeader
    },
    mounted() {
        produit.randomProduit(9).then((response) => {
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

.comment_track{
    display: flex;
    width: calc(100% * 10);
    animation: scroll 30s infinite;
}

.card {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin: 3px;
    max-width: 350px;
    width: 100%;
    font-family: Arial, sans-serif;
}

.profile {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.profile-image {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    margin-right: 10px;
}

.profile-info h2 {
    margin: 0;
    font-size: 18px;
}

.description {
    font-size: 14px;
    color: #333;
    margin: 15px 0;
}

.date {
    font-size: 12px;
    color: #888;
    text-align: right;
    margin: 0;
}


.comments{
    margin: 10px;
    padding: 15px;
    display: flex;
    flex-direction: row;
}

.comment_item{
    background-color: #fff;
    width: 300px;
    height: 150px;
    border-radius: 15px;
}

a {
    text-decoration: none;
}

</style>
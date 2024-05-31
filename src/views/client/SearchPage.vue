<template>
    <TheHeader></TheHeader>

    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <h1 class="page-name">Produit</h1>
                        <ol class="breadcrumb">
                            <li><a href="index.html">Home</a></li>
                            <li class="active">search</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="products section">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="widget">
                        <h4 class="widget-title">Trier par : </h4>
                        <form @submit.prevent="search">
                            <p>Catégorie</p>
                            <CFormSelect v-model="filtre.categorie_id" class="form-control mb-4"  aria-label="Default select example" id="categorie">
                                <option value=""> Selectionner une catégorie </option>
                                <option v-for="(item, index) in categories" :key="index"  :value="item.id"> {{ item.libelle }} </option>
                            </CFormSelect>

                            <p>Marque </p>
                            <CFormSelect class="mb-4 form-control" v-model="filtre.marque_id" id="marque" aria-label="Default select example">
                                <option value=""> Selectionner une marque </option>
                                <option v-for="(item, index) in marques" :key="index" :value="item.id"> {{ item.nom }} </option>
                            </CFormSelect>

                            <p>Prix</p>
                            <input v-model="filtre.prix_min" class="form-control mb-3" type="number"
                                placeholder="Ecrivez un montant ici">

                                <input v-model="filtre.prix_max" class="form-control mb-3" type="number"
                                placeholder="Ecrivez un montant ici">

                            <button type="submit" class="btn btn-lg btn-outline-success">Filtrer</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div v-for="(item, index) in filteredProduits" :key="index" class="col-md-4">
                            <div class="product-item">
                                <div class="product-thumb">
                                    <img class="img-responsive" src="@/assets/images/shop/products/product-9.jpg"
                                        alt="product-img" />
                                    <div class="preview-meta">
                                        <ul>
                                            <li @click="addToCart(item)">
                                                <span data-toggle="modal" data-target="#product-modal">
                                                    <i class="tf-ion-android-add"></i>
                                                </span>
                                            </li>
                                            <li @click="addToFavoris(item.id)" v-if="isConnected" >
                                                <a href="#!"><i class="tf-ion-ios-heart"></i></a>
                                            </li>
                                            <!-- <li @click="deleteFromFavoris(item.id)" v-if="isConnected" >
                                                <a href="#!"><i class="tf-ion-ios-heart-outline"></i></a>
                                            </li> -->
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

            </div>
        </div>
    </section>

    <TheFooter></TheFooter>
</template>

<script>

import TheFooter from '@/components/client/TheFooter'
import TheHeader from '@/components/client/TheHeader'
import store from '../../store';
import { categorie, marque, produit } from '../../services';

export default {

    components: {
        TheFooter, TheHeader
    },
    mounted() {
        categorie.allCategorie().then((response) => {
            this.categories = response.data.categories
        })

        marque.allMarque().then((response) => {
            this.marques = response.data.marques
        })
    },
    data() {
        return {
            filtre: {
                categorie_id: '',
                marque_id: '',
                prix_min: '',
                prix_max: ''
            },
            isConnected: store.getters.isConnect,
            marques: [],
            categories: [],
            filteredProduits: []
        }
    },
    methods: {
        search(){
            console.log(this.filtre);
            this.filteredProduits = []
            produit.searchProduit(this.filtre).then((response) => {
                console.log(response); 
                this.filteredProduits = response.data
            } )
        },
        addToCart(element) {
            store.commit('addToCart', element)
        },
        goDetails(id) {
            localStorage.setItem('id_produit', id)
        },
    },

}
</script>

<style lang="stylus" scoped>

</style>
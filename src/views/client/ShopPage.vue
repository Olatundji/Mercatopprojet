<template>
    <TheHeader></TheHeader>

    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <h1 class="page-name">Shop</h1>
                        <ol class="breadcrumb">
                            <li><a href="index.html">Home</a></li>
                            <li class="active">shop</li>
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
                        <form action="#">
                            <p>Catégorie</p>
                            <select v-model="filtre.categorie_id" class="form-control mb-4">
                                <option>Man</option>
                                <option>Women</option>
                                <option>Accessories</option>
                                <option>Shoes</option>
                            </select>
                            <p>Marque </p>
                            <select v-model="filtre.marque_id" class="mb-4 form-control">
                                <option>Autre</option>
                                <option>Women</option>
                                <option>Accessories</option>
                                <option>Shoes</option>
                            </select>
                            <p>Prix</p>
                            <input v-model="filtre.prix" class="form-control mb-3" type="text"
                                placeholder="Ecrivez un montant ici">
                            <button type="submit" class="btn btn-lg btn-outline-success">Filtrer</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div v-for="(item, index) in produits" :key="index" class="col-md-4">
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
                                            <li @click="deleteFromFavoris(item.id)" v-if="isConnected" >
                                                <a href="#!"><i class="tf-ion-ios-heart-outline"></i></a>
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
                        <div ref="sentinel" class="sentinel"></div>
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
import store from '../../store';
import { produit, favoris } from '../../services';

export default {
    components: {
        TheHeader, TheFooter
    },
    data() {
        return {
            isConnected: store.getters.isConnect,
            user_id: store.getters.getUser.id,
            produits: [],
            showedProducts: [],
            productIndex: 0,
            productPerLoad: 5,
            filtre: {
                categorie_id: '',
                marque_id: '',
                prix: ''
            },
            actionCart: true,
            page: 1,
            isLoading: false
        }
    },

    mounted() {
        console.log();
        this.page = 1
        this.allProduit()
        this.createObserver();

    },
    beforeUnmount() {
        if (this.observer) {
            this.observer.disconnect();
        }
    },
    methods: {
        userFavaoris(){
            favoris.userFavoris(this.user_id).then((response) => {
                console.log(response);
            } )
        },
        addToFavoris(id){
            favoris.createFavoris(id, this.user_id).then((response) => {
                console.log(response);
            })
        },
        deleteToFavoris(id){
            console.log(id);
        },
        createObserver() {
            const options = {
                root: this.$refs.scrollContainer,
                rootMargin: '0px',
                threshold: 1.0
            };

            this.observer = new IntersectionObserver(this.handleIntersect, options);
            this.observer.observe(this.$refs.sentinel);
        },
        handleIntersect(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    this.onScrollEnd();
                }
            });
        },
        onScrollEnd() {
            this.page++
            produit.allProduit(this.page, 10).then((response) => {
                this.produits.push(...response.data.produits)
            })

            this.produits = this.produits.reduce((acc, current) => {
                    const x = acc.find(item => item.id === current.id);
                    if (!x) {
                        return acc.concat([current]);
                    }
                    return acc;
                }, []);
        },
        goDetails(id) {
            localStorage.setItem('id_produit', id)
        },
        async allProduit() {
            await produit.allProduit().then((response) => {
                this.produits = response.data.produits
                // console.log(this.produits.length);
            })
        },
        addToCart(element) {
            store.commit('addToCart', element)
        },
    },
}
</script>

<style scoped>
.sentinel {
    height: 1px;
}
</style>
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
                <div class="col-md-9">
                    <div class="row">
                        <div v-for="(item, index) in produits" :key="index" class="col-md-4">
                            <div class="product-item">
                                <div class="product-thumb">
                                    <img class="img-responsive" :src="item.image" alt="product-img" />
                                    <div class="preview-meta">
                                        <ul>
                                            <li @click="addToCart(item)">
                                                <span data-toggle="modal" data-target="#product-modal">
                                                    <i class="tf-ion-android-add"></i>
                                                </span>
                                            </li>
                                            <li @click="addToFavoris(item.id)" v-if="isConnected">
                                                <a href="#!"><i class="tf-ion-ios-heart"></i></a>
                                            </li>
                                            <li v-if="isConnected">
                                                <a href="#!"><i class="tf-ion-ios-heart-outline"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <router-link class="product-name" :to="{ name: `DetailsProduit` }"
                                        @click="goDetails(item.id)">
                                        {{ item.nom }}
                                    </router-link>
                                    <p class="price"> {{ item.prix }} </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row arround">
            <div class="col-md-11">
                <button @click="onScrollEnd" class="btn btn-block btn-dark">Voir plus</button>
            </div>
        </div>
    </section>

    <TheFooter />
    <!-- <div ref="sentinel" class="sentinel"></div> -->
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
            user_id: null,
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
        }
    },

    mounted() {
        // this.createObserver();
        this.page = 1
        this.allProduit()

    },
    beforeUnmount() {
        if (this.observer) {
            this.observer.disconnect();
        }
    },
    methods: {
        userFavaoris() {
            favoris.userFavoris(store.getters.getUser.id).then((response) => {
                console.log(response);
            })
        },
        addToFavoris(id) {
            favoris.createFavoris(id, store.getters.getUser.id).then((response) => {
                console.log(response);
            }).catch((error) => {
                console.log(error);
            })

        },
        deleteToFavoris(id) {
            console.log(id);
        },
        // async createObserver() {
        //     const options = {
        //         root: null,
        //         rootMargin: '0px',
        //         threshold: 1.0
        //     };

        //     this.observer = new IntersectionObserver(this.handleIntersect, options);
        //     this.observer.observe(this.$refs.sentinel);
        // },
        // handleIntersect(entries) {
        //     entries.forEach(entry => {
        //         if (entry.isIntersecting) {
        //             console.log(entry);
        //             this.onScrollEnd();
        //         }
        //     });
        // },
        async onScrollEnd() {
            this.page++
            await produit.allProduit(this.page, 10).then((response) => {
                const newProducts = response.data.produits.filter(newProduct =>
                    !this.produits.some(existingProduct => existingProduct.id === newProduct.id)
                );
                this.produits.push(...newProducts);
            });
        },
        goDetails(id) {
            localStorage.setItem('id_produit', id)
        },
        async allProduit() {
            await produit.allProduit(1, 10).then((response) => {
                this.produits = response.data.produits
            })
        },
        addToCart(element) {
            store.commit('addToCart', element)
        },
    },
}
</script>

<style scoped>
.arround {
    margin: 20px;
}

.btn-dark {
    background-color: #333;
    padding: 5px;
    margin: 15px;
    border-radius: 10px;
}

.btn-dark:hover {
    background-color: rgb(170, 166, 166);
    border: 1px solid #333;
    color: black;
}


.sentinel {
    height: 1px;
}

.espace {
    height: 900px;
}

.product-name {
    font-family: 'Arial, sans-serif';
    /* Utilisation d'une police sans-serif */
    font-size: 1.5em;
    /* Taille de la police */
    font-weight: bold;
    /* Gras pour mettre en valeur le nom */
    color: #333;
    /* Couleur du texte */
    text-transform: capitalize;
    /* Capitalise chaque mot */
    text-align: center;
    /* Centrer le texte */
    margin: 20px 0;
    /* Marge pour espacer les éléments */
    transition: color 0.3s ease;
    /* Transition pour l'effet au survol */
}

.product-name:hover {
    color: #ff6347;
    /* Couleur du texte au survol */
}
</style>
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
                                        alt="product-img"/>
                                    <div class="preview-meta">
                                        <ul>
                                            <li>
                                                <span  data-toggle="modal" data-target="#product-modal">
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
                                        <router-link to='#'>
                                            {{ item.nom }}
                                        </router-link>
                                    </h4>
                                    <p class="price">XOF {{ item.prix }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div ref="endArticleSection"></div>
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
import { produit } from '../../services';

export default {
    components: {
        TheHeader, TheFooter
    },
    data() {
        return {
            produits: [],
            // produits: [
            //     {
            //         qte: 15,
            //         id: 1,
            //         nom: 'Rainbow Shoes',
            //         prix: 200,
            //         image: '@/assets/images/shop/products/product-9.jpg'
            //     },
            //     {
            //         qte: 15,
            //         id: 2,
            //         nom: 'Rainbow Shoes',
            //         prix: 200,
            //         image: '@/assets/images/shop/products/product-2.jpg'
            //     },
            //     {
            //         qte: 15,
            //         id: 3,
            //         nom: 'Rainbow Shoes',
            //         prix: 200,
            //         image: '@/assets/images/shop/products/product-9.jpg'
            //     },
            //     {
            //         qte: 15,
            //         id: 4,
            //         nom: 'Rainbow Shoes',
            //         prix: 150,
            //         image: '@/assets/images/shop/products/product-2.jpg'
            //     },
            //     {
            //         qte: 15,
            //         id: 5,
            //         nom: 'Rainbow Shoes',
            //         prix: 150,
            //         image: '@/assets/images/shop/products/product-9.jpg'
            //     },
            //     {
            //         qte: 15,
            //         id: 6,
            //         nom: 'Rainbow Shoes',
            //         prix: 200,
            //         image: '@/assets/images/shop/products/product-2.jpg'
            //     },
            //     {
            //         qte: 15,
            //         id: 7,
            //         nom: 'Rainbow Shoes',
            //         prix: 150,
            //         image: '@/assets/images/shop/products/product-9.jpg'
            //     },
            //     {
            //         qte: 15,
            //         id: 8,
            //         nom: 'Rainbow Shoes',
            //         prix: 200,
            //         image: '@/assets/images/shop/products/product-3.jpg'
            //     },
            //     {
            //         qte: 15,
            //         id: 9,
            //         nom: 'Rainbow Shoes',
            //         prix: 150,
            //         image: '@/assets/images/shop/products/product-9.jpg'
            //     },
            //     {
            //         qte: 15,
            //         id: 10,
            //         nom: 'Rainbow Shoes',
            //         prix: 200,
            //         image: '@/assets/images/shop/products/product-3.jpg'
            //     },
            //     {
            //         qte: 15,
            //         id: 11,
            //         nom: 'Rainbow Shoes',
            //         prix: 200,
            //         image: '@/assets/images/shop/products/product-9.jpg'
            //     },
            //     {
            //         qte: 15,
            //         id: 12,
            //         nom: 'Rainbow Shoes',
            //         prix: 150,
            //         image: '@/assets/images/shop/products/product-9.jpg'
            //     },
            //     {
            //         qte: 15,
            //         id: 13,
            //         nom: 'Rainbow Shoes',
            //         prix: 200,
            //         image: '@/assets/images/shop/products/product-3.jpg'
            //     },
            //     {
            //         qte: 15,
            //         id: 14,
            //         nom: 'Rainbow Shoes',
            //         prix: 200,
            //         image: '@/assets/images/shop/products/product-9.jpg'
            //     },
            //     {
            //         qte: 15,
            //         id: 15,
            //         nom: 'Rainbow Shoes',
            //         prix: 150,
            //         image: '@/assets/images/shop/products/product-3.jpg'
            //     },
            //     {
            //         qte: 15,
            //         id: 16,
            //         nom: 'Rainbow Shoes',
            //         prix: 200,
            //         image: '@/assets/images/shop/products/product-9.jpg'
            //     },
            //     {
            //         qte: 15,
            //         id: 17,
            //         nom: 'Rainbow Shoes',
            //         prix: 200,
            //         image: '@/assets/images/shop/products/product-9.jpg'
            //     },
            //     {
            //         qte: 15,
            //         id: 18,
            //         nom: 'Rainbow Shoes',
            //         prix: 200,
            //         image: '@/assets/images/shop/products/product-9.jpg'
            //     },
            //     {
            //         qte: 15,
            //         id: 19,
            //         nom: 'Rainbow Shoes',
            //         prix: 200,
            //         image: '@/assets/images/shop/products/product-9.jpg'
            //     },
            //     {
            //         qte: 15,
            //         id: 20,
            //         nom: 'Rainbow Shoes',
            //         prix: 200,
            //         image: '@/assets/images/shop/products/product-9.jpg'
            //     },
            //     {
            //         qte: 15,
            //         id: 21,
            //         nom: 'Rainbow Shoes',
            //         prix: 200,
            //         image: '@/assets/images/shop/products/product-9.jpg'
            //     },
            //     {
            //         qte: 15,
            //         id: 22,
            //         nom: 'Rainbow Shoes',
            //         prix: 200,
            //         image: '@/assets/images/shop/products/product-9.jpg'
            //     },
            //     {
            //         qte: 15,
            //         id: 23,
            //         nom: 'Rainbow Shoes',
            //         prix: 200,
            //         image: '@/assets/images/shop/products/product-9.jpg'
            //     },
            //     {
            //         qte: 15,
            //         id: 24,
            //         nom: 'Rainbow Shoes',
            //         prix: 200,
            //         image: '@/assets/images/shop/products/product-9.jpg'
            //     },
            //     {
            //         qte: 15,
            //         id: 25,
            //         nom: 'Rainbow Shoes',
            //         prix: 200,
            //         image: '@/assets/images/shop/products/product-9.jpg'
            //     },
            //     {
            //         qte: 15,
            //         id: 26,
            //         nom: 'Rainbow Shoes',
            //         prix: 200,
            //         image: '@/assets/images/shop/products/product-9.jpg'
            //     },
            //     {
            //         qte: 15,
            //         id: 27,
            //         nom: 'Rainbow Shoes',
            //         prix: 200,
            //         image: '@/assets/images/shop/products/product-9.jpg'
            //     },
            //     {
            //         qte: 15,
            //         id: 28,
            //         nom: 'Rainbow Shoes',
            //         prix: 200,
            //         image: '@/assets/images/shop/products/product-9.jpg'
            //     },
            //     {
            //         qte: 15,
            //         id: 29,
            //         nom: 'Rainbow Shoes',
            //         prix: 200,
            //         image: '@/assets/images/shop/products/product-9.jpg'
            //     },
            //     {
            //         qte: 15,
            //         id: 30,
            //         nom: 'Rainbow Shoes',
            //         prix: 200,
            //         image: '@/assets/images/shop/products/product-9.jpg'
            //     },
            //     {
            //         qte: 15,
            //         id: 31,
            //         nom: 'Rainbow Shoes',
            //         prix: 200,
            //         image: '@/assets/images/shop/products/product-9.jpg'
            //     },
            //     {
            //         qte: 15,
            //         id: 32,
            //         nom: 'Rainbow Shoes',
            //         prix: 200,
            //         image: '@/assets/images/shop/products/product-9.jpg'
            //     },
            // ],
            showedProducts: [],
            productIndex: 0,
            productPerLoad:5,
            filtre: {
                categorie_id: '',
                marque_id: '',
                prix: ''
            },
            actionCart: true
        }
    },

    mounted() {
        // this.setupScrollListener();
        // this.showMuch()
        this.allProduit()

    },
    beforeUnmount(){
        if (this.observer) {
        this.observer.disconnect();
    }
    },
    methods: {
        async allProduit(){
            await produit.allProduit().then((response) => {
                console.log(response.data.produits);
                this.produits  = response.data.produits 
                // console.log(this.produits.length);
            } )
        },
        addToCart(element){
            store.commit('addToCart', element)
        },
        // async showMuch() {
        //     const start = this.productIndex;
        //     const end = start + this.productPerLoad;
        //     const moreProducts = this.produits.slice(start, end);

        //     this.showedProducts.push(...moreProducts);
        //     this.productIndex = end;
        // },
        // setupScrollListener() {
        //     const options = {
        //         root: null,
        //         rootMargin: '0px',
        //         threshold: 0.1
        //     };

        //     this.observer = new IntersectionObserver(this.handleIntersect, options);
        //     this.observer.observe(this.$refs.endArticleSection);
        // },

        // // eslint-disable-next-line no-unused-vars
        // handleIntersect(entries, observer) {
        //     entries.forEach(entry => {
        //         if (entry.isIntersecting) {
        //             this.showMuch(); // Appeler la méthode souhaitée
        //         }
        //     });
        // }
    },
}
</script>
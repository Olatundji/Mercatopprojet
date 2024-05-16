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
                            <input v-model="filtre.prix" class="form-control mb-3" type="text" placeholder="Ecrivez un montant ici">
                            <button type="submit" class="btn btn-lg btn-outline-success" >Filtrer</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row">

                        <div class="col-md-4">
                            <div class="product-item">
                                <div class="product-thumb">
                                    <span class="bage">Sale</span>
                                    <img class="img-responsive" src="@/assets/images/shop/products/product-1.jpg"
                                        alt="product-img"/>
                                    <div class="preview-meta">
                                        <ul>
                                            <li>
                                                <a href="#!"><i class="tf-ion-ios-heart"></i></a>
                                            </li>
                                            <li>
                                                <a href="#!"><i class="tf-ion-android-cart"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h4><a href="product-single.html">Reef Boardsport</a></h4>
                                    <p class="price">$200</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="product-item">
                                <div class="product-thumb">
                                    <img class="img-responsive" src="@/assets/images/shop/products/product-2.jpg"
                                        alt="product-img" />
                                    <div class="preview-meta">
                                        <ul>
                                            <li>
                                                <a href="#"><i class="tf-ion-ios-heart"></i></a>
                                            </li>
                                            <li>
                                                <a href="#!"><i class="tf-ion-android-cart"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h4><a href="product-single.html">Rainbow Shoes</a></h4>
                                    <p class="price">$200</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="product-item">
                                <div class="product-thumb">
                                    <img class="img-responsive" src="@/assets/images/shop/products/product-3.jpg"
                                        alt="product-img" />
                                    <div class="preview-meta">
                                        <ul>
                                            <li>
                                                <a href="#"><i class="tf-ion-ios-heart"></i></a>
                                            </li>
                                            <li>
                                                <a href="#!"><i class="tf-ion-android-cart"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h4><a href="product-single.html">Strayhorn SP</a></h4>
                                    <p class="price">$230</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="product-item">
                                <div class="product-thumb">
                                    <img class="img-responsive" src="@/assets/images/shop/products/product-4.jpg"
                                        alt="product-img" />
                                    <div class="preview-meta">
                                        <ul>
                                            <li>
                                                <a href="#"><i class="tf-ion-ios-heart"></i></a>
                                            </li>
                                            <li>
                                                <a href="#!"><i class="tf-ion-android-cart"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h4><a href="product-single.html">Bradley Mid</a></h4>
                                    <p class="price">$200</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="product-item">
                                <div class="product-thumb">
                                    <img class="img-responsive" src="@/assets/images/shop/products/product-5.jpg"
                                        alt="product-img" />
                                    <div class="preview-meta">
                                        <ul>
                                            <li>
                                                <a href="#"><i class="tf-ion-ios-heart"></i></a>
                                            </li>
                                            <li>
                                                <a href="#!"><i class="tf-ion-android-cart"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h4><a href="product-single.html">Rainbow Shoes</a></h4>
                                    <p class="price">$200</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="product-item">
                                <div class="product-thumb">
                                    <img class="img-responsive" src="@/assets/images/shop/products/product-6.jpg"
                                        alt="product-img" />
                                    <div class="preview-meta">
                                        <ul>
                                            <li>
                                                <a href="#"><i class="tf-ion-ios-heart"></i></a>
                                            </li>
                                            <li>
                                                <a href="#!"><i class="tf-ion-android-cart"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h4><a href="product-single.html">Rainbow Shoes</a></h4>
                                    <p class="price">$200</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="product-item">
                                <div class="product-thumb">
                                    <span class="bage">Sale</span>
                                    <img class="img-responsive" src="@/assets/images/shop/products/product-7.jpg"
                                        alt="product-img" />
                                    <div class="preview-meta">
                                        <ul>
                                            <li>
                                                <a href="#"><i class="tf-ion-ios-heart"></i></a>
                                            </li>
                                            <li>
                                                <a href="#!"><i class="tf-ion-android-cart"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h4><a href="product-single.html">Rainbow Shoes</a></h4>
                                    <p class="price">$200</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="product-item">
                                <div class="product-thumb">
                                    <img class="img-responsive" src="@/assets/images/shop/products/product-8.jpg"
                                        alt="product-img" />
                                    <div class="preview-meta">
                                        <ul>
                                            <li>
                                                <a href="#"><i class="tf-ion-ios-heart"></i></a>
                                            </li>
                                            <li>
                                                <a href="#!"><i class="tf-ion-android-cart"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h4><a href="product-single.html">Rainbow Shoes</a></h4>
                                    <p class="price">$200</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="product-item">
                                <div class="product-thumb">
                                    <img class="img-responsive" src="@/assets/images/shop/products/product-9.jpg"
                                        alt="product-img" />
                                    <div class="preview-meta">
                                        <ul>
                                            <li>
                                                <a href="#"><i class="tf-ion-ios-heart"></i></a>
                                            </li>
                                            <li>
                                                <a href="#!"><i class="tf-ion-android-cart"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h4><a href="product-single.html">Rainbow Shoes</a></h4>
                                    <p class="price">$200</p>
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

import TheHeader from '@/components/client/TheHeader.vue'
import TheFooter from '@/components/client/TheFooter.vue'

export default {
    components: {
        TheHeader, TheFooter
    },
    data() {
        return {
            produits:[],
            filtre: {
                categorie_id: '',
                marque_id: '',
                prix: ''
            }
        }
    },
    methods: {
        
    },
}
</script>
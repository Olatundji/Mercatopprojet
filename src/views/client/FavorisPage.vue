<template>
    <TheHeader></TheHeader>
    <div class="page-wrapper">
        <div class="cart shopping">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="block">
                            <div class="product-list">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nom</th>
                                            <th>Marque</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in favoris" :key="index">
                                            <td>
                                                <div class="product-info">
                                                    {{ index + 1 }}
                                                </div>
                                            </td>
                                            <td> {{ item.produit.nom  }} </td>
                                            <td> {{ item.produit.marque_nom  }} </td>
                                            <td>
                                                <a @click.prevent="deleteFromFavoris(item.favori_id)" class="product-remove"
                                                    href="#">Supprimer</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
    </div>
    <TheFooter></TheFooter>
</template>

<script>

import TheHeader from '@/components/client/TheHeader'
import TheFooter from '@/components/client/TheFooter'
import { favoris } from '../../services';
import store from '../../store';

    export default {
        mounted() {
            favoris.userFavoris(store.getters.getUser.id).then((response) => {
                this.favoris = response.data
            }).catch((error) => {
                console.log(error);
            } )
        },
        data() {
            return {
                favoris: {}
            }
        },
        methods: {
            deleteFromFavoris(id){
                favoris.deleteFavoris(id).then((response) => {
                    // console.log(response)
                    if(response.status == 200){
                        location.reload()
                    }
                } ).catch((error) => {
                    console.log(error);
                } )

                
            },
        },
        components: {
            TheFooter, TheHeader
        }
    }
</script>

<style lang="scss" scoped>

</style>
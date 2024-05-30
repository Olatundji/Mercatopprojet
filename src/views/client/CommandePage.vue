<template>
    <div v-if="detailModal" class="modal-custom" @click="closeModalOutside">
        <div class="modal-content">
            <span class="close" @click="closeModal">&times;</span>
            <h2>Produits de la commande</h2>
            <CModalTitle>Liste des produits de la commande</CModalTitle>
            <CModalBody>
                <ul>
                    <li v-for="produit in selectedCommande.produits" :key="produit.nom_produit">
                        Nom du produit : {{ produit.nom_produit }}, Quantité : {{ produit.quantite_produit }}
                    </li>
                </ul>
            </CModalBody>
            <CModalFooter>
                <CButton color="secondary" @click="closeModal">Fermer</CButton>
            </CModalFooter>
        </div>
    </div>

    <TheHeader></TheHeader>
    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <h1 class="page-name">Dashboard</h1>
                        <ol class="breadcrumb">
                            <li><router-link to="/">Home</router-link></li>
                            <li class="active">commandes</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="user-dashboard page-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="dashboard-wrapper user-dashboard">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Nombre de produits</th>
                                        <th>Montant</th>
                                        <th>Methode de paiement</th>
                                        <th>Status de la commande</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in commandes" :key="index">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ item.date }}</td>
                                        <td>{{ item.produits.length }}</td>
                                        <td>{{ item.montant }}</td>
                                        <td>{{ item.method_pay }}</td>
                                        <td><span class="label label-primary"> {{ item.etat }} </span></td>
                                        <td><a @click.prevent="details(item)" href="#" class="btn btn-default">Voir plus</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <TheFooter></TheFooter>
</template>


<script>
import TheHeader from '../../components/client/TheHeader.vue';
import TheFooter from '../../components/client/TheFooter.vue';
import { commande } from '../../services';
import store from '../../store';

export default {
    components: {
        TheHeader, TheFooter
    },
    mounted() {
        commande.userCommandes(store.getters.getUser.id).then((response) => {
            this.commandes = response.data;
            console.log(response);
        });
    },
    data() {
        return {
            commandes: [],
            detailModal: false,
            selectedCommande: null
        }
    },
    methods: {
        closeModalOutside(event) {
            if (event.target.classList.contains('modal-custom')) {
                this.closeModal();
            }
        },
        closeModal() {
            this.detailModal = false;
            this.selectedCommande = null;
        },
        details(commande) {
            this.selectedCommande = commande;
            this.detailModal = true;
        }
    }
}
</script>


<style scoped>
.modal-custom {
    align-self: center;
    z-index: 1;
    display: flex;
    position: fixed;
    left: 0;
    top: -10px;
    bottom: -110px;
    width: 100%;
    height: auto;
    overflow: scroll;
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 40%;
    height: auto;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
</style>
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

    <CRow>
        <CTable caption="top">
            <CTableCaption>Liste des produits</CTableCaption>
            <CTableHead>
                <CTableRow>
                    <CTableHeaderCell scope="col">#</CTableHeaderCell>
                    <CTableHeaderCell scope="col">Id Transaction</CTableHeaderCell>
                    <CTableHeaderCell scope="col">Methode de payement</CTableHeaderCell>
                    <CTableHeaderCell scope="col">Montant</CTableHeaderCell>
                    <CTableHeaderCell scope="col">Date</CTableHeaderCell>
                    <CTableHeaderCell scope="col">Etat</CTableHeaderCell>
                    <CTableHeaderCell scope="col">Plus d'information</CTableHeaderCell>
                </CTableRow>
            </CTableHead>
            <CTableBody>
                <CTableRow v-for="(item, index) in commandes" :key="index" >
                    <CTableDataCell>{{ index + 1 }}</CTableDataCell>
                    <CTableDataCell>{{ item.transaction }}</CTableDataCell>
                    <CTableDataCell>{{ item.method_pay }}</CTableDataCell>
                    <CTableDataCell>{{ item.montant }} </CTableDataCell>
                    <CTableDataCell> {{ item.date }} </CTableDataCell>
                    <CTableDataCell>
                        <CButton @click="valider(item.id)" class="label label-primary" v-if="item.etat == 'pending'" color="info" >En attente</CButton>
                        <span v-if="item.etat === 'validated' " class="label label-success" >Complete</span>
                    </CTableDataCell>
                    <CTableDataCell > <CButton @click.prevent="details(item)" color="warning" > Voir plus </CButton>  </CTableDataCell>
                </CTableRow>
            </CTableBody>
        </CTable>
    </CRow>
</template>

<script>

import { ref } from 'vue';
import { commande } from '../../../services';
import Swal from 'sweetalert2';

export default {
    mounted() {
        commande.allCommandes().then((response) => {
            this.commandes = response.data
            console.log(response);
        } )
    },
    name: "ListeCommande",
    setup() {
        const visibleModal = ref(false)
        return { visibleModal }
    },
    data() {
        return {
            commandes: [],
            detailModal: false,
        }
    },
    methods: {
        valider(id){
            Swal.fire({
                title: 'Êtes vous sûr ?',
                text: "Cette commande sera valider "+ id,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, valider !',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    commande.validateCommande(id).then((response) => {
                        if (response.status == 200) {
                            Swal.fire(
                                'Valider !',
                                'La commande a bien été valider',
                                'success'
                            ).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload()
                                }
                            })
                        }
                    })
                }
            })
        },
        details(commande) {
            this.selectedCommande = commande;
            this.detailModal = true;
        },
        closeModalOutside(event) {
            if (event.target.classList.contains('modal-custom')) {
                this.closeModal();
            }
        },
        closeModal() {
            this.detailModal = false;
            this.selectedCommande = null;
        },
    },
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
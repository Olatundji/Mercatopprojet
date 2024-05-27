<template>
    <div v-if="updateModal" class="modal-custom" @click="closeModalOutside">
        <div class="modal-content">
            <span class="close" @click="closeModal">&times;</span>
            <h2>Modifier une catégorie</h2>
            <CForm enctype=“multipart/form-data” @submit.prevent="updateProduit">
                <CModalTitle>Modifier les informations d'un produit</CModalTitle>
            <CModalBody>
                <CRow>
                    <CCol :md="6">
                        <div class="mb-2">
                            <CFormLabel for="nom">Nom</CFormLabel>
                            <CFormInput v-model="produitUpdate.nom" id="nom" type="text" placeholder="Barcelet Guici" />
                        </div>
                    </CCol>
                    <CCol :md="6">
                        <div class="mb-2">
                            <CFormLabel for="prix">Prix en (FCFA)</CFormLabel>
                            <CFormInput v-model="produitUpdate.prix" id="prix" type="number" placeholder="5000" />
                        </div>
                    </CCol>
                </CRow>
                <div class="mb-2">
                    <CFormLabel for="description">Description</CFormLabel>
                    <CFormTextarea placeholder="C'est un bracelet premium fait en or massif"
                        v-model="produitUpdate.description" id="description" rows="3"></CFormTextarea>
                </div>
                <CRow>
                    <CCol :md="6">
                        <div class="mb-2">
                            <CFormLabel for="marque">Marque</CFormLabel>
                            <CFormSelect id="marque" v-model="produitUpdate.marque_id" aria-label="Default select example">
                                <option v-for="(item, index) in marques" :key="index" :value="item.id"> {{ item.nom }} </option>
                            </CFormSelect>
                        </div>
                    </CCol>
                    <CCol :md="6">
                        <div class="mb-2">
                            <CFormLabel for="categorie">Categorie</CFormLabel>
                            <CFormSelect v-model="produitUpdate.categorie_id" aria-label="Default select example" id="categorie">
                                <option v-for="(item, index) in categories" :key="index"  :value="item.id"> {{ item.libelle }} </option>
                            </CFormSelect>
                        </div>
                    </CCol>
                </CRow>
                <CRow>
                    <CCol :md="6">
                        <div class="mb-2">
                            <CFormLabel for="qte">Quantité</CFormLabel>
                            <CFormInput v-model="produitUpdate.qte"  id="qte" type="number" placeholder="5" />
                        </div>
                    </CCol>
                    <CCol :md="6">
                        <div class="mb-2">
                            <CFormLabel for="image">Image</CFormLabel>
                            <CFormInput id="image" accept=".png, .jpg, .jpeg"  @change="handleFileChange" type="file" />
                        </div>
                    </CCol>
                </CRow>
                <CRow>
                    <CCol :md="6">
                        <div class="mb-2">
                            <CFormLabel for="qte">Quantité</CFormLabel>
                            <CFormInput v-model="produitUpdate.qte" id="qte" type="number" placeholder="5" />
                        </div>
                    </CCol>
                    <CCol :md="6">
                        <div class="mb-2">
                            <CFormLabel for="image">Image</CFormLabel>
                            <CFormInput id="image" accept=".png, .jpg, .jpeg" @change="handleFileChange" type="file"
                                placeholder="Barcelet Guici" />
                        </div>
                    </CCol>
                </CRow>
            </CModalBody>
            <CModalFooter>
                <CButton color="secondary" @click="closeModal">
                    Fermer
                </CButton>
                <CButton type="submit" color="primary">Modifier </CButton>
            </CModalFooter>
        </CForm>
        </div>
    </div>
    <CRow>
        <CTable caption="top">
            <CTableCaption>Liste des produits</CTableCaption>
            <CTableHead>
                <CTableRow>
                    <CTableHeaderCell scope="col">#</CTableHeaderCell>
                    <CTableHeaderCell scope="col">Nom</CTableHeaderCell>
                    <CTableHeaderCell scope="col">Description</CTableHeaderCell>
                    <CTableHeaderCell scope="col">Prix</CTableHeaderCell>
                    <CTableHeaderCell scope="col">Quantité</CTableHeaderCell>
                    <CTableHeaderCell scope="col">Marque</CTableHeaderCell>
                    <CTableHeaderCell scope="col">Catégorie</CTableHeaderCell>
                    <CTableHeaderCell class="center">Action</CTableHeaderCell>
                </CTableRow>
            </CTableHead>
            <CTableBody>
                <CTableRow v-for="(item,index) in produits" :key="item.id" >
                    <CTableDataCell> {{ index + 1 }} </CTableDataCell>
                    <CTableDataCell> {{ item.nom }} </CTableDataCell>
                    <CTableDataCell> {{ item.description }} </CTableDataCell>
                    <CTableDataCell> {{ item.prix }} </CTableDataCell>
                    <CTableDataCell> {{ item.qte }} </CTableDataCell>
                    <CTableDataCell> {{ item.marque.nom }} </CTableDataCell>
                    <CTableDataCell>{{ item.categorie.nom }}</CTableDataCell>
                    <CTableDataCell class="center">
                        <CButton class="mr" color="warning" @click="showUpdateModal(item.id)">Modifier</CButton>
                        <CButton @click="deleteProduit(item.id)" color="danger"> Supprimer</CButton>
                    </CTableDataCell>
                </CTableRow>
            </CTableBody>
        </CTable>
    </CRow>
</template>

<script>


import Swal from 'sweetalert2';
import { produit, categorie, marque } from '../../../services';

export default {
    mounted() {
        produit.allProduit(1, 100).then((response) => {
            // console.log(response);
            this.produits = response.data.produits
        })

        categorie.allCategorie().then((response) => {
            this.categories = response.data.categories
        })

        marque.allMarque().then((response) => {
            this.marques = response.data.marques
        })
    },
    name: "ListeProduit",
    data() {
        return {
            updateModal: false,
            produitUpdate: {
                nom: "",
                description: "",
                qte: "",
                prix: "",
                image: "",
                categorie_id: '',
                marque_id: ''
            },
            produit: {
                nom: "",
                description: "",
                qte: "",
                prix: "",
                image: "",
                categorie_id: "",
                marque_id: ""
            },
            produits: [],
            categories: [],
            marques: []
        }
    },
    methods: {
        deleteProduit(id){
            Swal.fire({
                title: 'Êtes vous sûr?',
                text: "Ce produit sera définitivement supprimé "+ id,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, supprimer!',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    produit.deleteProduit(id).then((response) => {
                        if (response.status == 200) {
                            Swal.fire(
                                'Supprimé !',
                                'Le produit a bien été supprimé',
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
        updateProduit() {
            produit.updateProduit(this.id, this.produitUpdate).then((response) => {
                if (response.status == 200) {
                    Swal.fire(
                        'Modifié !',
                        'Le produit a bien été mis à jour',
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload()
                        }
                    })
                }
            })
            console.log(this.produitUpdate);
            this.closeModal()
        },
        showUpdateModal(id) {
            const data = this.produits.find((element) => element.id == id)
            this.produitUpdate.nom = data.nom
            this.produitUpdate.description = data.description
            this.produitUpdate.qte = data.qte
            this.produitUpdate.prix = data.prix
            this.produitUpdate.categorie_id = data.categorie.id
            this.produitUpdate.marque_id = data.marque.id
            this.produitUpdate.nom = data.nom
            this.updateModal = true
            this.id = id
        },
        closeModalOutside(event) {
            if (event.target.classList.contains('modal-custom')) {
                this.closeModal();
            }
        },
        closeModal() {
            this.isModalOpen = false;
            this.updateModal = false
        },
    },
}
</script>

<style scoped>

.modal-custom {
    z-index: 1;
    display: flex;
    position: fixed;
    left: 0;
    top: 0;
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

.mr {
    margin-right: 20px;
}

.center {
    text-align: center;
}
</style>
<template>
    <CModal :visible="visibleModal" @close="() => { visibleModal = false }">
        <CForm @submit.prevent="updateProduit">
            <CModalHeader dismiss @close="() => {
                visibleModal = false
            }
                ">
                <CModalTitle>Modifier les informations d'un produit</CModalTitle>
            </CModalHeader>
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
                                <option>Open this select menu</option>
                                <option value="1">Gucuci</option>
                                <option value="1">Nike</option>
                            </CFormSelect>
                        </div>
                    </CCol>
                    <CCol :md="6">
                        <div class="mb-2">
                            <CFormLabel for="categorie">Categorie</CFormLabel>
                            <CFormSelect v-model="produitUpdate.categorie_id" aria-label="Default select example"
                                id="categorie">
                                <option disabled>Open this select menu</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </CFormSelect>
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
                <CButton color="secondary" @click="() => {
                    visibleModal = false
                }
                    ">
                    Close
                </CButton>
                <CButton type="submit" color="primary">Save changes</CButton>
            </CModalFooter>
        </CForm>
    </CModal>
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
                <CTableRow v-for="item in produits" :key="item.id" >
                    <CTableDataCell> {{ item.id }} </CTableDataCell>
                    <CTableDataCell> {{ item.nom }} </CTableDataCell>
                    <CTableDataCell> {{ item.description }} </CTableDataCell>
                    <CTableDataCell> {{ item.prix }} </CTableDataCell>
                    <CTableDataCell> {{ item.qte }} </CTableDataCell>
                    <CTableDataCell> {{ item.marque_id }} </CTableDataCell>
                    <CTableDataCell>{{ item.categorie_id }}</CTableDataCell>
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

import { ref } from 'vue';
import Swal from 'sweetalert2';

export default {
    name: "ListeProduit",
    setup() {
        const visibleModal = ref(false)
        return { visibleModal }
    },
    data() {
        return {
            produitUpdate: {
                nom: "",
                description: "",
                qte: "",
                prix: "",
                image: "",
                categorie_id: "",
                marque_id: ""
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
            produits: [
                {
                    id: 1, 
                    nom: "Montre",
                    description: "Montre de luxe",
                    prix: 1500000,
                    qte: 500,
                    marque_id: 3,
                    categorie_id: 4 
                },
                {
                    id: 2, 
                    nom: "Collier",
                    description: "Collier de luxe",
                    prix: 190000,
                    qte: 20,
                    marque_id: 2,
                    categorie_id: 3 
                },
                {
                    id: 3, 
                    nom: "Chaine",
                    description: "Chaine de luxe",
                    prix: 1578000,
                    qte: 5,
                    marque_id: 1,
                    categorie_id: 2 
                },
                {
                    id: 4, 
                    nom: "Chaine ",
                    description: "Chaine de luxe",
                    prix: 90068,
                    qte: 320,
                    marque_id: 4,
                    categorie_id: 1 
                },
                {
                    id: 5, 
                    nom: "Bracelet",
                    description: "Bracelet de luxe",
                    prix: 5541300,
                    qte: 415,
                    marque_id: 4,
                    categorie_id: 4 
                },
            ],
            categories: [
                {id: 1, libelle: "Montre"},
                {id: 2, libelle: "Bracelet"},
                {id: 3, libelle: "Chaine"},
                {id: 4, libelle: "Collier"},
            ],
            marques: [
                {id: 1, libelle: "Nike"},
                {id: 2, libelle: "Adidas"},
                {id: 3, libelle: "Gucci"},
                {id: 4, libelle: "Versace"},
            ]
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
                    Swal.fire(
                        'Supprimé !',
                        'Le produit a bien été supprimé',
                        'success'
                    )
                }
            })
        },
        updateProduit() {
            var form = document.getElementById('form');
            var formData = new FormData(form);

            formData.append("nom", this.produit.nom);
            formData.append("description", this.produit.description);
            formData.append("qte", this.produit.qte);
            formData.append("image", this.produit.image);
            formData.append("prix", this.produit.prix);
            formData.append("categorie_id", this.produit.categorie_id);
            formData.append("marque_id", this.produit.marque_id);
            console.log(this.produit);
        },
        showUpdateModal(id) {
            const data = this.produits.find((element) => element.id == id)
            this.produitUpdate.nom = data.nom
            this.produitUpdate.description = data.description
            this.produitUpdate.qte = data.qte
            this.produitUpdate.prix = data.prix
            this.produitUpdate.categorie_id = data.categorie_id
            this.produitUpdate.marque_id = data.marque_id
            this.produitUpdate.nom = data.nom
            console.log(this.produitUpdate);
            this.visibleModal = true
            this.id = id
        },
    },
}
</script>

<style scoped>
.mr {
    margin-right: 20px;
}

.center {
    text-align: center;
}
</style>
<template>
    <!-- Ligne des erreurs -->
    <div v-if="errors.length > 0" >
        <ul>
            <li v-for="(item, index) in errors" :key="index" > {{ item.message }} </li>
        </ul>
    </div>
    <CRow>
        <CCol :xs="12">
            <CCard class="mb-4">
                <CCardHeader>
                    <strong>Ajouter vos produits ici</strong>
                </CCardHeader>
                <CCardBody>
                    <CForm enctype=“multipart/form-data” @submit.prevent="addProduit" >
                        <CRow>
                            <CCol :md="6">
                                <div class="mb-2">
                                    <CFormLabel for="nom">Nom</CFormLabel>
                                    <CFormInput required v-model="produit.nom" id="nom" type="text" placeholder="Barcelet Guici" />
                                </div>
                            </CCol>
                            <CCol :md="6">
                                <div class="mb-2">
                                    <CFormLabel for="prix">Prix en (FCFA)</CFormLabel>
                                    <CFormInput required v-model="produit.prix"  id="prix" type="number" placeholder="5000" />
                                </div>
                            </CCol>
                        </CRow>
                        <div class="mb-2">
                            <CFormLabel for="description">Description</CFormLabel>
                            <CFormTextarea required placeholder="C'est un bracelet premium fait en or massif" v-model="produit.description" id="description" rows="3"></CFormTextarea>
                        </div>
                        <CRow>
                            <CCol :md="6">
                                <div class="mb-2">
                                    <CFormLabel for="marque">Marque</CFormLabel>
                                    <CFormSelect required id="marque" v-model="produit.idMarque" aria-label="Default select example">
                                        <option v-for="(item, index) in marques" :key="index" :value="item.id"> {{ item.nom }} </option>
                                    </CFormSelect>
                                </div>
                            </CCol>
                            <CCol :md="6">
                                <div class="mb-2">
                                    <CFormLabel for="categorie">Categorie</CFormLabel>
                                    <CFormSelect required v-model="produit.idCategorie" aria-label="Default select example" id="categorie">
                                        <option v-for="(item, index) in categories" :key="index"  :value="item.id"> {{ item.libelle }} </option>
                                    </CFormSelect>
                                </div>
                            </CCol>
                        </CRow>
                        <CRow>
                            <CCol :md="6">
                                <div class="mb-2">
                                    <CFormLabel for="qte">Quantité</CFormLabel>
                                    <CFormInput required v-model="produit.qte"  id="qte" type="number" placeholder="5" />
                                </div>
                            </CCol>
                            <CCol :md="6">
                                <div class="mb-2">
                                    <CFormLabel for="image">Image</CFormLabel>
                                    <CFormInput required id="image" accept=".png, .jpg, .jpeg"  @change="handleFileChange" type="file" />
                                </div>
                            </CCol>
                        </CRow>
                        <div class="col-auto">
                            <CButton color="success" type="submit"> Ajouter </CButton>
                        </div>
                        <img :src="imgSrc" alt="En attente de chargement">
                    </CForm>
                </CCardBody>
            </CCard>
        </CCol>
    </CRow>
</template>

<script>

import router from '../../../router';
import { categorie, marque, produit  } from '../../../services';

export default {
    name: "CreateProduit",
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
            produit: {
                nom: "",
                qte: "",
                description: "",
                image: "",
                prix: "",
                idCategorie: '',
                idMarque: ''
            },
            errors: [],
            categories:[],
            marques: [],
            imgSrc: null
        }
    },
    methods: {
        handleFileChange(event){
            let file = this.produit.image = event.target.files[0]
            const link = URL.createObjectURL(file)
            this.imgSrc = link
        },
        addProduit(){
            this.errors = []
            let formData = new FormData()

            formData.append('nom', this.produit.nom)
            formData.append('qte', this.produit.qte)
            formData.append('description', this.produit.description)
            formData.append('image', this.produit.image)
            formData.append('prix', this.produit.prix)
            formData.append('idCategorie', this.produit.idCategorie)
            formData.append('idMarque', this.produit.idMarque)
            console.log(formData);

            produit.createProduit(formData).then((response) => {
                console.log(response);
                if(response.status == 200 || response.status == 201 ){
                    router.push({name: `Liste des Produits`})
                }
            }).catch(error => {
                console.log(error);
                if(error.response.status == 500){
                    const obj = {message: "Une erreur s'est produite lors de la création "}
                    this.errors.push(obj)
                }
            })
        }
    },
}

</script>

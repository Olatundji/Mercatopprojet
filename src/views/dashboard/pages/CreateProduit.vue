<template>
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
                                    <CFormInput v-model="produit.nom" id="nom" type="text" placeholder="Barcelet Guici" />
                                </div>
                            </CCol>
                            <CCol :md="6">
                                <div class="mb-2">
                                    <CFormLabel for="prix">Prix en (FCFA)</CFormLabel>
                                    <CFormInput v-model="produit.prix"  id="prix" type="number" placeholder="5000" />
                                </div>
                            </CCol>
                        </CRow>
                        <div class="mb-2">
                            <CFormLabel for="description">Description</CFormLabel>
                            <CFormTextarea placeholder="C'est un bracelet premium fait en or massif" v-model="produit.description" id="description" rows="3"></CFormTextarea>
                        </div>
                        <CRow>
                            <CCol :md="6">
                                <div class="mb-2">
                                    <CFormLabel for="marque">Marque</CFormLabel>
                                    <CFormSelect id="marque" v-model="produit.idMarque" aria-label="Default select example">
                                        <option>Open this select menu</option>
                                        <option value="1">Gucuci</option>
                                        <option value="2">Nike</option>
                                    </CFormSelect>
                                </div>
                            </CCol>
                            <CCol :md="6">
                                <div class="mb-2">
                                    <CFormLabel for="categorie">Categorie</CFormLabel>
                                    <CFormSelect v-model="produit.idCategorie" aria-label="Default select example" id="categorie">
                                        <option>Open this select menu</option>
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
                                    <CFormInput v-model="produit.qte"  id="qte" type="number" placeholder="5" />
                                </div>
                            </CCol>
                            <CCol :md="6">
                                <div class="mb-2">
                                    <CFormLabel for="image">Image</CFormLabel>
                                    <CFormInput id="image" accept=".png, .jpg, .jpeg"  @change="handleFileChange" type="file" placeholder="Barcelet Guici" />
                                </div>
                            </CCol>
                        </CRow>
                        <div class="col-auto">
                            <CButton color="success" type="submit"> Ajouter </CButton>
                        </div>
                    </CForm>
                </CCardBody>
            </CCard>
        </CCol>
    </CRow>
</template>

<script>

import { produit } from '../../../services';

export default {
    name: "CreateProduit",
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
            errors: []
        }
    },
    methods: {
        handleFileChange(event){
            this.produit.image = event.target.files[0]
            console.log(event.target.files[0]);
        },
        addProduit(){
            console.log(this.produit);
            produit.createProduit(this.produit).then((response) => {
                console.log(response);
            }).catch(error => {
                console.log(error.response);
                // if(error.response.data.status == 500){
                //     const obj = {message: "Une erreur s'est produite lors de la création "}
                //     this.errors.push(obj)
                // }
            })
        }
    },
}

</script>

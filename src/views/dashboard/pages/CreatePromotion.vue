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
                    <strong>Ajouter un nouveau code promo</strong>
                </CCardHeader>
                <CCardBody>
                    <CForm enctype=“multipart/form-data” @submit.prevent="addPromo" >
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
                            <CCol :md="12">
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

// import router from '../../../router';
import { produit  } from '../../../services';

export default {
    name: "CreateProduit",
    mounted() {
        produit.allProduit(1,500).then((response) => {
            console.log(response);
            this.produits = response.data
        } )
    },
    data() {
        return {
            promotion: {
                code: '',
                reduction: '',
                date_debut: '',
                date_fin: '',
                idProduit: '',
            },
            errors: [],
            produits: [],
        }
    },
    methods: {
        addPromo(){
            this.errors = []
            let formData = new FormData()
            console.log(formData);

        }
    },
}

</script>

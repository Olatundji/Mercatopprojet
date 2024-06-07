<template>
    <CRow>
        <CCol :xs="12">
            <CCard class="mb-4">
                <CCardHeader>
                    <strong>Paramétrez les informations de votre site ici </strong>
                </CCardHeader>
                <CCardBody>
                    <CForm enctype=“multipart/form-data” @submit.prevent="updateSiteInfos">
                        <CRow>
                            <CCol :md="6">
                                <div class="mb-2">
                                    <CFormLabel for="nom">Nom</CFormLabel>
                                    <CFormInput v-model="boutique.nom" id="nom" type="text"
                                        placeholder="Barcelet Guici" />
                                </div>
                            </CCol>
                            <CCol :md="6">
                                <div class="mb-2">
                                    <CFormLabel for="slogan">Slogan</CFormLabel>
                                    <CFormInput v-model="boutique.slogan" id="slogan" type="text"
                                        placeholder="Votre beau, notre préocupation" />
                                </div>
                            </CCol>
                        </CRow>
                        <CRow>
                            <CCol :md="6">
                                <div class="mb-2">
                                    <CFormLabel for="adresse">Adresse</CFormLabel>
                                    <CFormInput placeholder="C'est un bracelet premium fait en or massif"
                                        v-model="boutique.adresse" id="adresse"></CFormInput>
                                </div>
                            </CCol>
                            <CCol :md="6">
                                <div class="mb-2">
                                    <CFormLabel for="logo">Logo</CFormLabel>
                                    <CFormInput id="logo" accept=".png, .jpg, .jpeg" @change="handleFileChange"
                                        type="file" placeholder="Barcelet Guici" />
                                </div>
                            </CCol>
                        </CRow>
                        <CRow>
                            <CCol :md="6" class="mb-3">
                                <img :src="imgSrc" alt="Image en attente de chargement">
                            </CCol>
                        </CRow>
                        <div class="col-auto">
                            <CButton color="success" type="submit"> Modifier </CButton>
                        </div>
                    </CForm>
                </CCardBody>
            </CCard>
        </CCol>
    </CRow>
</template>

<script>
import { boutique } from '../../../services';
import Axios from '../../../services/caller';
import store from '../../../store';


export default {
    name: "CreateProduit",
    data() {
        return {
            boutique: {
                nom: store.getters.getSiteInfos.nom,
                slogan: store.getters.getSiteInfos.slogan,
                adresse: store.getters.getSiteInfos.adresse,
                logo: store.getters.getSiteInfos.logo
            },
            imgSrc: ''
        }
    },
    mounted() {
        boutique.getBoutiqueInfos().then((response) => {
            console.log(response);
        } )
    },
    methods: {
        handleFileChange(event) {
            const file = this.boutique.logo = event.target.files[0]
            const link = URL.createObjectURL(file)
            this.imgSrc = link
        },
        updateSiteInfos() {
            var formData = new FormData()
            formData.append("nom", this.boutique.nom)
            formData.append("slogan", this.boutique.slogan)
            formData.append("adresse", this.boutique.adresse)
            formData.append("logo", this.boutique.logo)

            Axios.post('parametres/update/'+1, formData).then((response) => {
                console.log(response);
                if(response.status == 200){
                    store.commit('setSiteInfos', response.data)
                    location.reload()
                }
            } )
        }
    },
}

</script>

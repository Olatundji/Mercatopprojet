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
                            <CButton color="success" type="submit"> Ajouter </CButton>
                        </div>
                    </CForm>
                </CCardBody>
            </CCard>
        </CCol>
    </CRow>
</template>

<script>

export default {
    name: "CreateProduit",
    data() {
        return {
            boutique: {
                nom: "",
                slogan: "",
                adresse: "",
                logo: "",
            },
            imgSrc: ''
        }
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

            // Display the key/value pairs
            // for (var pair of formData.entries()) {
            //     console.log(pair[0] + ':  ' + pair[1]);
            // }
        }
    },
}

</script>

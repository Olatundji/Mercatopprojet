
<template>
    <CRow>
        <CCol :xs="12">
            <CCard class="mb-4">
                <CCardHeader>
                    <strong>Ajouter les articles du blog ici</strong>
                </CCardHeader>
                <CCardBody>
                    <CForm enctype=“multipart/form-data” @submit.prevent="publier" >
                        <CRow>
                            <CCol :md="6">
                                <div class="mb-2">
                                    <CFormLabel for="titre">Titre</CFormLabel>
                                    <CFormInput v-model="article.titre" id="titre" type="text" placeholder="Titre de l'article" />
                                </div>
                            </CCol>
                            <CCol :md="6">
                                <div class="mb-2">
                                    <CFormLabel for="description">Description</CFormLabel>
                                    <CFormTextarea placeholder="Une description précise de l'article" v-model="article.description" id="description" rows="3"></CFormTextarea>
                                </div>
                            </CCol>
                        </CRow>
                        <CRow>
                            <CCol :md="6" >
                                <div class="mb-2">
                                    <CFormLabel for="marque">Catégorie d'article</CFormLabel>
                                    <CFormSelect  id="marque" v-model="article.categorie_article_id">
                                        <option disabled >Open this select menu</option>
                                        <option  v-for="item in categories" :key="item.id" :value="item.id">  {{ item.libelle }} </option>
                                    </CFormSelect>
                                </div>
                            </CCol>
                            <CCol :md="6">
                                <div class="mb-2">
                                    <CFormLabel for="description">Contenu</CFormLabel>
                                    <CFormTextarea placeholder="Le contenu de l'article" v-model="article.contenu" id="description" rows="4"></CFormTextarea>
                                </div>
                            </CCol>
                        </CRow>
                        <CRow>
                            <CCol :md="12">
                                <div class="mb-2">
                                    <CFormLabel for="image">Image</CFormLabel>
                                    <CFormInput id="image" accept=".png, .jpg, .jpeg"  @change="handleFileChange" type="file" />
                                </div>
                            </CCol>
                        </CRow>
                        <CRow>
                            <CCol>
                                <div class="mt-2">
                                    <img width="800" :src="imgSrc" alt="Image en attende de chargement">
                                </div>
                            </CCol>
                        </CRow>
                        <div class="col-auto">
                            <CButton class="mt-3" color="success" type="submit"> Publier </CButton>
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
            article: {
                contenu: "",
                image: "",
                titre: "",
                description: "",
                categorie_article_id: ''
            },
            imgSrc: '',
            categories: [
                { libelle: "Nouveau", id: 1 },
                { libelle: "Ici et ailleur", id: 2 },
                { libelle: "La nouvelle mode", id: 3 },
                { libelle: "Astuce pour homme", id: 4 },
                { libelle: "Astuce pour femme", id: 5 },
                { libelle: "Faits divers", id: 6 },
            ]
        }
    },
    methods: {
        handleFileChange(event){
            const file = this.article.image = event.target.files[0]
            const link = URL.createObjectURL(file)
            this.imgSrc = link
        },
        publier(){
            var formData = new FormData()
            formData.append("contenu", this.article.contenu)
            formData.append("description", this.article.description)
            formData.append("titre", this.article.titre)
            formData.append("categorie_article_id", this.article.categorie_article_id)
            formData.append("image", this.article.image)
            console.log(this.article)
            // console.log(formData)
        }
    },
}

</script>

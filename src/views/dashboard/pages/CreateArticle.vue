
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
                                    <CFormLabel for="categorie">Catégorie d'article</CFormLabel>
                                    <CFormSelect  id="categorie" v-model="article.categorieArticle_id">
                                        <option  v-for="item in categorie_article" :key="item.id" :value="item.id">  {{ item.libelle }} </option>
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

import { article, categorie_article } from '../../../services'
import router from '../../../router';

export default {
    name: "CreateProduit",
    mounted() {
        categorie_article.allCategorieArticle().then((response) => {
            this.categorie_article = response.data
        })
    },
    data() {
        return {
            article: {
                contenu: "",
                image: "",
                titre: "",
                description: "",
                categorieArticle_id: ''
            },
            imgSrc: '',
            categorie_article: []
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
            formData.append("idCategorie_article", this.article.categorieArticle_id)
            formData.append("image", this.article.image)
            console.log(this.article)
            article.createArticle(formData).then((response) => {
                console.log(response);
                if(response.status == 200 || response.status == 201 ){
                    router.push({name: `Liste des articles`})
                }
            }).catch((error) => {
                console.log(error);
            } )

        }
    },
}

</script>

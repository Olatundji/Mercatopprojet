<template>
    <CModal :visible="visibleModal" @close="() => { visibleModal = false }">
        <CForm @submit.prevent="updateArticle">
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
                            <CFormLabel for="titre">Titre</CFormLabel>
                            <CFormInput v-model="articleUpdate.titre" id="titre" type="text" placeholder="Titre de l'article" />
                        </div>
                    </CCol>
                    <CCol :md="6">
                        <div class="mb-2">
                            <CFormLabel for="description">Description</CFormLabel>
                            <CFormTextarea placeholder="Une description précise de l'article" v-model="articleUpdate.description" id="description" rows="3"></CFormTextarea>
                        </div>
                    </CCol>
                </CRow>
                <CRow>
                    <CCol :md="6" >
                        <div class="mb-2">
                            <CFormLabel for="categorie">Catégorie d'article</CFormLabel>
                            <CFormSelect  id="categorie" v-model="articleUpdate.categorie_id">
                                <option disabled >Open this select menu</option>
                                <option v-for="item in categories" :key="item.id" :value="item.id">  {{ item.libelle }} </option>
                            </CFormSelect>
                        </div>
                    </CCol>
                    <CCol :md="6">
                        <div class="mb-2">
                            <CFormLabel for="description">Contenu</CFormLabel>
                            <CFormTextarea placeholder="Le contenu de l'article" v-model="articleUpdate.contenu" id="description" rows="4"></CFormTextarea>
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
            </CModalBody>
            <CModalFooter>
                <CButton color="secondary" @click="() => {
                    visibleModal = false
                }
                    ">
                    Close
                </CButton>
                <CButton type="submit" color="primary">Modifier</CButton>
            </CModalFooter>
        </CForm>
    </CModal>

    <div v-if="updateModal" class="modal-custom" @click="closeModalOutside">
        <div class="modal-content">
            <span class="close" @click="closeModal">&times;</span>
            <h2>Modifier un article</h2>
            <CForm @submit.prevent="updateArticle">
                <CModalTitle>Modifier les informations d'un article</CModalTitle>
                <CModalBody>
                    <CRow>
                        <CCol :md="6">
                            <div class="mb-2">
                                <CFormLabel for="titre">Titre</CFormLabel>
                                <CFormInput v-model="articleUpdate.titre" id="titre" type="text" placeholder="Titre de l'article" />
                            </div>
                        </CCol>
                        <CCol :md="6">
                            <div class="mb-2">
                                <CFormLabel for="description">Description</CFormLabel>
                                <CFormTextarea placeholder="Une description précise de l'article" v-model="articleUpdate.description" id="description" rows="3"></CFormTextarea>
                            </div>
                        </CCol>
                    </CRow>
                    <CRow>
                        <CCol :md="6" >
                            <div class="mb-2">
                                <CFormLabel for="categorie">Catégorie d'article</CFormLabel>
                                <CFormSelect  id="categorie" v-model="articleUpdate.categorie_id">
                                    <option disabled >Open this select menu</option>
                                    <option v-for="item in categorie_article" :key="item.id" :value="item.id">  {{ item.libelle }} </option>
                                </CFormSelect>
                            </div>
                        </CCol>
                        <CCol :md="6">
                            <div class="mb-2">
                                <CFormLabel for="description">Contenu</CFormLabel>
                                <CFormTextarea placeholder="Le contenu de l'article" v-model="articleUpdate.contenu" id="description" rows="4"></CFormTextarea>
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
                </CModalBody>
                <CModalFooter>
                    <CButton color="secondary" @click="() => {
                        visibleModal = false
                    }
                        ">
                        Close
                    </CButton>
                    <CButton type="submit" color="primary">Modifier</CButton>
                </CModalFooter>
            </CForm>
        </div>
    </div>
    <CRow>
        <CTable caption="top">
            <CTableHead>
                <CTableRow>
                    <CTableHeaderCell scope="col">#</CTableHeaderCell>
                    <CTableHeaderCell scope="col">Titre</CTableHeaderCell>
                    <CTableHeaderCell scope="col">Description</CTableHeaderCell>
                    <CTableHeaderCell scope="col">Contenu</CTableHeaderCell>
                    <CTableHeaderCell scope="col">Catégorie</CTableHeaderCell>
                    <CTableHeaderCell colspan="2">Action</CTableHeaderCell>
                </CTableRow>
            </CTableHead>
            <CTableBody>
                <CTableRow v-for="(item, index) in articles" :key="item.id">
                    <CTableDataCell> {{ index +1  }} </CTableDataCell>
                    <CTableDataCell> {{ item.titre }} </CTableDataCell>
                    <CTableDataCell> {{ item.description }} </CTableDataCell>
                    <CTableDataCell> {{ item.contenu }} </CTableDataCell>
                    <CTableDataCell>{{ item.categorie.nom }}</CTableDataCell>
                    <CTableDataCell>
                        <CButton class="mr" color="warning" @click="showUpdateModal(item.id)">Modifier</CButton>
                    </CTableDataCell>
                    <CTableDataCell>
                        <CButton @click="deleteArticles(item.id)" color="danger"> Supprimer</CButton>
                    </CTableDataCell>
                    
                </CTableRow>
            </CTableBody>
        </CTable>
    </CRow>
</template>

<script>

import Swal from 'sweetalert2';
import { article, categorie_article } from '../../../services';

export default {
    name: "ListeProduit",
    mounted() {
        article.allArticle().then((response) => {
            console.log(response);
            this.articles = response.data
        } )


        categorie_article.allCategorieArticle().then((response) => {
            this.categorie_article = response.data
        } )
    },
    data() {
        return {
            articleUpdate: {
                id:'',
                titre: "",
                description: "",
                contenu: "",
                image: "",
                categorie_id: "",
            },
            updateModal: false,
            articles: [],
            categorie_article: []
        }
    },
    methods: {
        deleteArticles(id) {
            Swal.fire({
                title: 'Êtes vous sûr?',
                text: "Cet article sera définitivement supprimé " + id,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, supprimer!',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    article.deleteArticle(id).then((response) => {
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
        updateArticle() {
            
            var formData = new FormData()
            formData.append("contenu", this.articleUpdate.contenu)
            formData.append("description", this.articleUpdate.description)
            formData.append("titre", this.articleUpdate.titre)
            formData.append("idCategorie_article", this.articleUpdate.categorie_article_id)
            formData.append("image", this.articleUpdate.image)

            article.updateArticle(this.id, formData).then((response) => {
                console.log(response);
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
            const data = this.articles.find((element) => element.id == id)
            this.articleUpdate.id = data.id
            this.articleUpdate.titre = data.titre
            this.articleUpdate.description = data.description
            this.articleUpdate.contenu = data.contenu
            this.articleUpdate.prix = data.prix
            console.log(data.categorie_id);
            this.articleUpdate.categorie_id = data.categorie_id
            console.log(this.articleUpdate);
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
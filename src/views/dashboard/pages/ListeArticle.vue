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
                <CTableRow v-for="item in articles" :key="item.id">
                    <CTableDataCell> {{ item.id }} </CTableDataCell>
                    <CTableDataCell> {{ item.titre }} </CTableDataCell>
                    <CTableDataCell> {{ item.description }} </CTableDataCell>
                    <CTableDataCell> {{ item.contenu }} </CTableDataCell>
                    <CTableDataCell>{{ item.categorie_id }}</CTableDataCell>
                    <CTableDataCell>
                        <CButton class="mr" color="warning" @click="showUpdateModal(item.id)">Modifier</CButton>
                        <CButton @click="deleteArticles(item.id)" color="danger"> Supprimer</CButton>
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
            articleUpdate: {
                id:'',
                titre: "",
                description: "",
                contenu: "",
                image: "",
                categorie_id: "",
            },
            articles: [
                {
                    id: 1,
                    titre: "L'intelligence artificielle",
                    description: "Découvrez comment l'IA automatise des tâches",
                    contenu: "L'intelligence artificielle (IA) est en train de changer le monde du travail à un rythme fulgurant.",
                    categorie_id: 2,
                    image: "url_image_1.jpg"
                },
                {
                    id: 2,
                    titre: "5 conseils pour bien choisir son assurance maladie",
                    description: "Découvrez comment l'IA automatise des tâches",
                    contenu: "L'intelligence artificielle (IA) est en train de changer le monde du travail à un rythme fulgurant.",
                    categorie_id: 3,
                    image: "url_image_2.jpg"
                },
                {
                    id: 3,
                    titre: "Les 12 parcs nationaux les plus beaux du Nord  des États-Unis",
                    description: "Découvrez comment l'IA automatise des tâches",
                    contenu: "L'intelligence artificielle (IA) est en train de changer le monde du travail à un rythme fulgurant.",
                    categorie_id: 2,
                    image: "url_image_4.jpg"
                },
                {
                    id: 4,
                    titre: "Les 5 parcs nationaux les plus beaux des États-Unis",
                    description: "Découvrez comment l'IA automatise des tâches",
                    contenu: "Découvrez comment l'IA automatise des tâches",
                    categorie_id: 4,
                    image: "url_image_4.jpg"
                },
                {
                    id: 5,
                    titre: "Les 10 parcs nationaux les plus beaux des États-Unis",
                    description: "Découvrez comment l'IA automatise des tâches",
                    contenu: "L'intelligence artificielle (IA) est en train de changer le monde du travail à un rythme fulgurant.",
                    categorie_id: 1,
                    image: "url_image_4.jpg"
                },
            ],
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
        deleteArticles(id) {
            Swal.fire({
                title: 'Êtes vous sûr?',
                text: "Ce produit sera définitivement supprimé " + id,
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
        updateArticle() {
            var formData = new FormData()

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
            const data = this.articles.find((element) => element.id == id)
            this.articleUpdate.id = data.id
            this.articleUpdate.titre = data.titre
            this.articleUpdate.description = data.description
            this.articleUpdate.contenu = data.contenu
            this.articleUpdate.prix = data.prix
            console.log(data.categorie_id);
            this.articleUpdate.categorie_id = data.categorie_id
            console.log(this.articleUpdate);
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
<template>

    <CModal :visible="modalUpdate" @close="() => { modalUpdate = false }">
        <CForm id="form" @submit.prevent="addCategorie">
            <CModalHeader dismiss @close="() => { modalUpdate = false }">
                <CModalTitle>Ajouter une categorie</CModalTitle>
            </CModalHeader>
            <CModalBody>

                <CRow>
                    <CCol :md="12">
                        <div class="mb-2">
                            <CFormLabel for="categorie">Libelle</CFormLabel>
                            <CFormInput v-model="categorie.libelle" id="categorie" type="text"
                                placeholder="Barcelet Guici" />
                        </div>
                    </CCol>
                </CRow>
            </CModalBody>
            <CModalFooter>
                <CButton color="secondary" @click="() => {
                    modalUpdate = false
                }
                    ">
                    Fermer
                </CButton>
                <CButton type="submit" color="primary">Ajouter</CButton>
            </CModalFooter>
        </CForm>

    </CModal>


    <CModal :visible="visibleModal" @close="() => { visibleModal = false }">
        <CForm id="form" @submit.prevent="updateCategorie">
            <CModalHeader dismiss @close="() => {visibleModal = false}
                ">
                <CModalTitle>Modifier les informations de la catégorie </CModalTitle>
            </CModalHeader>
            <CModalBody>

                <CRow>
                    <CCol :md="12">
                        <div class="mb-2">
                            <CFormLabel for="categorie">Libellé</CFormLabel>
                            <CFormInput v-model="libelle" id="categorie" type="text" placeholder="Barcelet Guici" />
                        </div>
                    </CCol>
                </CRow>
            </CModalBody>
            <CModalFooter>
                <CButton color="secondary" @click="() => {
                    visibleModal = false
                }
                    ">
                    Fermer
                </CButton>
                <CButton type="submit" color="primary">Modifier</CButton>
            </CModalFooter>
        </CForm>
    </CModal>

    <CRow>
        <CButton class="mr" color="success" @click="() => { modalUpdate = true }
            ">Ajouter une Catégorie</CButton>
    </CRow>
    <CRow>
        <CTable caption="top">
            <CTableCaption>Liste des catégories</CTableCaption>
            <CTableHead>
                <CTableRow>
                    <CTableHeaderCell scope="col">#</CTableHeaderCell>
                    <CTableHeaderCell scope="col">Libelle</CTableHeaderCell>
                    <CTableHeaderCell class="center">Action</CTableHeaderCell>
                </CTableRow>
            </CTableHead>
            <CTableBody>
                <CTableRow v-for="item in categories" :key="item.id">
                    <CTableDataCell> {{ item.id }} </CTableDataCell>
                    <CTableDataCell> {{ item.libelle }} </CTableDataCell>
                    <CTableDataCell class="center">
                        <CButton class="mr" color="warning" @click="showModal(item.id)">Modifier</CButton>
                        <CButton @click="deleteCategorie(item.id)" color="danger"> Supprimer</CButton>
                    </CTableDataCell>
                </CTableRow>
            </CTableBody>
        </CTable>
    </CRow>
</template>

<script>

import Swal from 'sweetalert2';
import { ref } from 'vue';
export default {
    name: "ListeCategorie",
    setup() {
        const visibleModal = ref(false)
        const modalUpdate = ref(false)
        return { visibleModal, modalUpdate }
    },
    data() {
        return {
            id: '',
            categorie: {
                libelle: "",
            },
            libelle: '',
            categories: [
                { libelle: "Montre", id: 1 },
                { libelle: "Bracelet", id: 2 },
                { libelle: "Parfum", id: 3 },
                { libelle: "Collier", id: 4 },
                { libelle: "Maquillage", id: 5 },
                { libelle: "Masque", id: 6 },
            ]
        }
    },
    methods: {
        // eslint-disable-next-line no-unused-vars
        deleteCategorie(id) {
            Swal.fire({
                title: 'Êtes vous sûr?',
                text: "Cette catégorie sera définitivement supprimé",
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
                        'La catégorie a bien été supprimé',
                        'success'
                    )
                }
            })
        },
        updateCategorie() {
            console.log("Vous venez de mettre a jour la catégorie " + this.id + " dont la nouvelle valeur est " + this.libelle);
        },
        showModal(id) {
            const data = this.categories.find((element) => element.id == id)
            this.libelle = data.libelle
            this.visibleModal = true
            this.id = id
        },
        addCategorie() {
            console.log("Vous venez d'ajouter la catégorie" + this.categorie.libelle);
        }
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
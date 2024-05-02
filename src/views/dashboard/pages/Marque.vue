<template>

    <CModal :visible="modalUpdate" @close="() => { modalUpdate = false }">
        <CForm id="form" @submit.prevent="addMarque">
            <CModalHeader dismiss @close="() => { modalUpdate = false }">
                <CModalTitle>Ajouter une marque</CModalTitle>
            </CModalHeader>
            <CModalBody>

                <CRow>
                    <CCol :md="12">
                        <div class="mb-2">
                            <CFormLabel for="categorie">Libelle</CFormLabel>
                            <CFormInput v-model="marque.libelle" id="categorie" type="text"
                                placeholder="Versace" />
                        </div>
                    </CCol>
                </CRow>
            </CModalBody>
            <CModalFooter>
                <CButton color="secondary" @click="() => {modalUpdate = false}
                    ">
                    Fermer
                </CButton>
                <CButton type="submit" color="primary">Ajouter</CButton>
            </CModalFooter>
        </CForm>

    </CModal>


    <CModal :visible="visibleModal" @close="() => { visibleModal = false }">
        <CForm id="form" @submit.prevent="updateMarque">
            <CModalHeader dismiss @close="() => {visibleModal = false}
                ">
                <CModalTitle>Modifier les informations de la marque </CModalTitle>
            </CModalHeader>
            <CModalBody>

                <CRow>
                    <CCol :md="12">
                        <div class="mb-2">
                            <CFormLabel for="categorie">Libellé</CFormLabel>
                            <CFormInput v-model="libelle" id="categorie" type="text" placeholder="Versace" />
                        </div>
                    </CCol>
                </CRow>
            </CModalBody>
            <CModalFooter>
                <CButton color="secondary" @click="() => {visibleModal = false}
                    ">
                    Fermer
                </CButton>
                <CButton type="submit" color="primary">Modifier</CButton>
            </CModalFooter>
        </CForm>
    </CModal>

    <CRow>
        <CButton class="mr" color="success" @click="() => { modalUpdate = true }
            ">Ajouter une Marque</CButton>
    </CRow>
    <CRow>
        <CTable caption="top">
            <CTableCaption>Liste des marques</CTableCaption>
            <CTableHead>
                <CTableRow>
                    <CTableHeaderCell scope="col">#</CTableHeaderCell>
                    <CTableHeaderCell scope="col">Libelle</CTableHeaderCell>
                    <CTableHeaderCell class="center">Action</CTableHeaderCell>
                </CTableRow>
            </CTableHead>
            <CTableBody>
                <CTableRow v-for="item in marques" :key="item.id">
                    <CTableDataCell> {{ item.id }} </CTableDataCell>
                    <CTableDataCell> {{ item.libelle }} </CTableDataCell>
                    <CTableDataCell class="center">
                        <CButton class="mr" color="warning" @click="showModal(item.id)">Modifier</CButton>
                        <CButton @click="deleteMarque(item.id)" color="danger"> Supprimer</CButton>
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
    // eslint-disable-next-line vue/multi-word-component-names
    name: "Marque",
    setup() {
        const visibleModal = ref(false)
        const modalUpdate = ref(false)
        return { visibleModal, modalUpdate }
    },
    data() {
        return {
            id: '',
            marque: {
                libelle: "",
            },
            libelle: '',
            marques: [
                { libelle: "Gucci", id: 1 },
                { libelle: "Dior", id: 2 },
                { libelle: "Vercase", id: 3 },
                { libelle: "Nike", id: 4 },
                { libelle: "Adidas", id: 5 },
                { libelle: "Inditex ", id: 6 },
            ]
        }
    },
    methods: {
        // eslint-disable-next-line no-unused-vars
        deleteMarque(id) {
            Swal.fire({
                title: 'Êtes vous sûr?',
                text: "Cette marque sera définitivement supprimé",
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
                        'La marque a bien été supprimé',
                        'success'
                    )
                }
            })
        },
        updateMarque() {
            console.log("Vous venez de mettre a jour la marque " + this.id + " dont la nouvelle valeur est " + this.libelle);
        },
        showModal(id) {
            const data = this.marques.find((element) => element.id == id)
            this.libelle = data.libelle
            this.visibleModal = true
            this.id = id
        },
        addMarque() {
            console.log("Vous venez d'ajouter la marque" + this.marque.libelle);
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
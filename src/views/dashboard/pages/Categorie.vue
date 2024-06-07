<template>

    <div v-if="isModalOpen" class="modal-custom" @click="closeModalOutside">
        <div class="modal-content">
            <span class="close" @click="closeModal">&times;</span>
            <h2>Ajouter une catégorie</h2>
            <form @submit.prevent="addCategorie">
                <div class="form-group">
                    <input v-model="categorie.libelle" type="text" class="form-control"
                        placeholder="Le nom de la cétégorie">
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-success">Ajouter</button>
                </div>
            </form>
        </div>
    </div>

    <div v-if="updateModal" class="modal-custom" @click="closeModalOutside">
        <div class="modal-content">
            <span class="close" @click="closeModal">&times;</span>
            <h2>Modifier une catégorie</h2>
            <form @submit.prevent="updateCategorie">
                <div class="form-group">
                    <input v-model="libelle" type="text" class="form-control" placeholder="Le nom de la cétégorie">
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-success">Changer</button>
                </div>
            </form>
        </div>
    </div>

    <CRow>
        <CButton class="mr" color="success" @click="openModal">Ajouter une Catégorie</CButton>
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
                <CTableRow v-for="(item, index) in categories" :key="item.id">
                    <CTableDataCell> {{ index + 1 }} </CTableDataCell>
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
import { categorie } from '../../../services';

export default {
    mounted() {
        categorie.allCategorie().then((response) => {
            this.categories = response.data.categories
        })
    },
    name: "ListeCategorie",
    data() {
        return {
            isModalOpen: false,
            updateModal: false,
            id: '',
            categorie: {
                libelle: "",
            },
            libelle: '',
            categories: []
        }
    },
    methods: {
        deleteCategorie(id) {
            Swal.fire({
                title: 'Êtes vous sûr ?',
                text: "Cette catégorie sera définitivement supprimé",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, supprimer!',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    categorie.deleteCategorie(id).then((response) => {
                        if (response.status == 200) {
                            Swal.fire(
                                'Supprimé !',
                                'La catégorie a bien été supprimé',
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
        updateCategorie() {
            this.closeModal()
            categorie.updateCategorie(this.id, this.libelle).then((response) => {
                if (response.status == 200) {
                    Swal.fire(
                        'Modifié !',
                        'La catégorie a bien été mis à jour',
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload()
                        }
                    })
                }
            })
        },
        showModal(id) {
            const data = this.categories.find((element) => element.id == id)
            this.libelle = data.libelle
            this.updateModal = true
            this.id = id
        },
        addCategorie() {
            categorie.createCategorie(this.categorie.libelle).then((response) => {
                if (response.status == 200) {
                    location.reload();
                }

            })
            this.closeModal();
        },
        closeModalOutside(event) {
            if (event.target.classList.contains('modal-custom')) {
                this.closeModal();
            }
        },
        openModal() {
            this.isModalOpen = true;
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
    width: 30%;
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
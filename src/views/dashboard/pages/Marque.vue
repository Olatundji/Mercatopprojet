<template>
    <div v-if="isModalOpen" class="modal-custom" @click="closeModalOutside">
        <div class="modal-content">
            <span class="close" @click="closeModal">&times;</span>
            <h2>Ajouter une marque</h2>
            <form @submit.prevent="addMarque">
                <div class="form-group">
                    <input v-model="marque.nom" type="text" class="form-control"
                        placeholder="Le nom de la marque">
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
            <h2>Modifier une marque</h2>
            <form @submit.prevent="updateMarque">
                <div class="form-group">
                    <input v-model="nom" type="text" class="form-control" placeholder="Le nom de la marque">
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-success">Changer</button>
                </div>
            </form>
        </div>
    </div>

    <CRow>
        <CButton class="mr" color="success" @click="openModal">Ajouter une Marque</CButton>
    </CRow>
    <CRow>
        <CTable caption="top">
            <CTableCaption>Liste des marques</CTableCaption>
            <CTableHead>
                <CTableRow>
                    <CTableHeaderCell scope="col">#</CTableHeaderCell>
                    <CTableHeaderCell scope="col">Nom</CTableHeaderCell>
                    <CTableHeaderCell class="center">Action</CTableHeaderCell>
                </CTableRow>
            </CTableHead>
            <CTableBody>
                <CTableRow v-for="(item, index ) in marques" :key="item.id">
                    <CTableDataCell> {{ index + 1 }} </CTableDataCell>
                    <CTableDataCell> {{ item.nom }} </CTableDataCell>
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
import { marque } from '../../../services';
export default {
    mounted() {
        marque.allMarque().then((response) => {
            this.marques = response.data.marques
        }).catch((error) => {
            if(error.response.data.status == 500){
                Swal.fire(
                    'Error',
                    "Une erreur s'est produite' ",
                    'danger'
                )
            }
        } )
    },
    name: "MarquePage",
    data() {
        return {
            isModalOpen: false,
            updateModal: false,
            id: '',
            marque: {
                nom: "",
            },
            nom: '',
            marques: []
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
                    marque.deleteMarque(id).then((response) => {
                        if (response.status == 200) {
                            Swal.fire(
                                'Supprimé !',
                                'La marque a bien été supprimé',
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
        updateMarque() {
            marque.updateMarque(this.id, this.nom).then((response) => {
                if (response.status == 200) {
                    Swal.fire(
                        'Modifié !',
                        'La marque a bien été modifié',
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
            const data = this.marques.find((element) => element.id == id)
            this.nom = data.nom
            this.updateModal = true
            this.id = id
        },
        addMarque() {
            marque.createMarque(this.marque.nom).then((response) => {
                if (response.status == 200) {
                    location.reload();
                }
            } )
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
    height: 100%;
    overflow: scroll;
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 30%;
    height: 40%;
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
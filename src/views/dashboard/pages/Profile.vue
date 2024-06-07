<template>
    <div v-if="isModalOpen" class="modal-custom" @click="closeModalOutside">
        <div class="modal-content">
            <span class="close" @click="closeModal">&times;</span>
            <h2>Changer le mot de passe</h2>
            <form @submit.prevent="changePassword">
                <div class="form-group">
                    <input v-model="password.newPassword" type="password" class="form-control" placeholder="Nouveau mot de passe">
                </div>
                <div class="form-group">
                    <input v-model="password.passwordConfirm" type="password" class="form-control" placeholder="Confirmer le mot de passe">
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-success">Changer</button>
                </div>
            </form>
        </div>
    </div>
    <CRow :xl="12" class="mb-3">
        <CCol>
            <CButton color="primary" class="custom-button" @click="openModal">Changer le mot de passe</CButton>


        </CCol>
    </CRow>
    <CRow>
        <CCol :xs="12">
            <CCard class="mb-4">
                <CCardHeader>
                    <strong>Vos informations</strong>
                </CCardHeader>
                <CCardBody>
                    <CForm @submit.prevent="updateProfile">
                        <div class="mb-2">
                            <CFormLabel for="exampleFormControlInput1">Nom</CFormLabel>
                            <CFormInput v-model="user.nom" id="name" type="text" placeholder="Exp : John Doe " />
                        </div>
                        <div class="mb-2">
                            <CFormLabel for="exampleFormControlInput1">Email address</CFormLabel>
                            <CFormInput v-model="user.email" id="exampleFormControlInput1" type="email" placeholder="name@example.com" />
                        </div>
                        <div class="mb-2">
                            <CFormLabel for="exampleFormControlInput1">Numéro</CFormLabel>
                            <CFormInput v-model="user.numero" id="exampleFormControlInput1" type="text" placeholder="Exp : +2299700257412" />
                        </div>
                        <div class="mb-2">
                            <CFormLabel for="exampleFormControlInput1">Adresse</CFormLabel>
                            <CFormInput v-model="user.adresse" id="exampleFormControlInput1" type="text" placeholder="Exp : +2299700257412" />
                        </div>
                        <div class="col-auto">
                            <CButton type="submit" class="bg-success"> Modifier </CButton>
                        </div>
                    </CForm>
                </CCardBody>
            </CCard>
        </CCol>
    </CRow>
</template>

<script>

import { ref } from 'vue'
import store from '@/store';
import { auth } from '../../../services';


export default {
    name: "ProfilePage",
    setup() {
        const visibleModal = ref(false)
        return {visibleModal}
    },
    data() {
        return {
            user:{
                nom: store.getters.getUser.nom,
                email: store.getters.getUser.email,
                numero: store.getters.getUser.numero,
                adresse: store.getters.getUser.adresse
            },
            user_id: store.getters.getUser.id,
            isModalOpen: false,
            password: {
                newPassword: '',
                passwordConfirm: ''
            }
        }
    },
    methods: {
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
        },

        changePassword() {
            console.log(this.password);
            this.closeModal();
        },
        updateProfile(){
            auth.updateProfile(this.user, this.user_id).then((response) => {
                console.log(response);
                if(response.status == 200){
                    console.log(response.data.user);
                    store.commit('setUser', response.data.user)
                }
            } )
        }
    },
};
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
</style>

<template>
    <CRow :xl="12" class="mb-3">
        <CCol>
            <CButton color="primary" @click="() => {visibleModal = true;}">Changer votre mot de passe</CButton>
            <CModal :visible="visibleModal" @close="() => {
                    visibleModal = false;
                }
                ">
                <CForm @submit.prevent="passwordInfos" >
                    <CModalHeader>
                        <CModalTitle>Modifier votre mot de passe</CModalTitle>
                    </CModalHeader>
                    <CModalBody>
                        
                            <div class="mb-2">
                                <CFormLabel for="exampleFormControlInput1">Nouveau mot de passe</CFormLabel>
                                <CFormInput v-model="password" id="password" type="password" />
                            </div>
                            <div class="mb-2">
                                <CFormLabel for="exampleFormControlInput1">Confirmer mot de passe</CFormLabel>
                                <CFormInput v-model="passwordConfirm" id="passwordConfirm" type="password"/>
                            </div>
                    </CModalBody>
                    <CModalFooter>
                        <CButton color="secondary" @click="() => {visibleModal = false;}">
                            Close
                        </CButton>
                        <CButton color="primary" type="submit" class="bg-success"> Enregistrer </CButton>
                    </CModalFooter>
                </CForm>
            </CModal>
        </CCol>
    </CRow>
    <CRow>
        <CCol :xs="12">
            <CCard class="mb-4">
                <CCardHeader>
                    <strong>Vos informations</strong>
                </CCardHeader>
                <CCardBody>
                    <CForm @submit.prevent="infos">
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
                            <CFormInput v-model="user.tel" id="exampleFormControlInput1" type="text" placeholder="Exp : +2299700257412" />
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

export default {
    name: "ProfilePage",
    setup() {
        const visibleModal = ref(false)
        return {visibleModal}
    },
    data() {
        return {
            user:{
                nom: "",
                email: "",
                tel: "",
            },
            password: "",
            passwordConfirm:""
        }
    },
    methods: {
        infos(){
            console.log(this.user);
        },
        passwordInfos(){
            console.log(this.password+ "||" +this.passwordConfirm);
        }
    },
};
</script>

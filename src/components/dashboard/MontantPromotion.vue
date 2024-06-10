<template>
    <CCol :xs="12">
        <CCard class="mb-4">
            <CCardHeader>
                <strong>Ajouter un nouveau code promo</strong>
            </CCardHeader>
            <CCardBody>
                <CForm @submit.prevent="addMontantPromotion">
                    <CRow>
                        <CCol :md="6">
                            <div class="mb-2">
                                <CFormLabel for="code">Code Promo</CFormLabel>
                                <CFormInput required v-model="promotion.code" id="code" type="text"
                                    placeholder="PROMO2024" />
                            </div>
                        </CCol>
                        <CCol :md="6">
                            <div class="mb-2">
                                <CFormLabel for="reduction">Réduction (%)</CFormLabel>
                                <CFormInput required v-model="promotion.reduction" id="reduction" type="number"
                                    placeholder="20" />
                            </div>
                        </CCol>
                    </CRow>
                    <CRow>
                        <CCol :md="6">
                            <div class="mb-2">
                                <CFormLabel for="date_debut">Date de Début</CFormLabel>
                                <CFormInput required v-model="promotion.date_debut" id="date_debut" type="date" />
                            </div>
                        </CCol>
                        <CCol :md="6">
                            <div class="mb-2">
                                <CFormLabel for="date_fin">Date de Fin</CFormLabel>
                                <CFormInput required v-model="promotion.date_fin" id="date_fin" type="date" />
                            </div>
                        </CCol>
                    </CRow>
                    <CCol :md="6">
                        <div class="mb-2">
                            <CFormLabel for="montant">Montant</CFormLabel>
                            <CFormInput required v-model="promotion.montant" id="montant" type="number"
                                placeholder="20" />
                        </div>
                    </CCol>
                    <div class="col-auto">
                        <CButton color="success" type="submit">Ajouter</CButton>
                    </div>
                </CForm>
            </CCardBody>
        </CCard>
    </CCol>
</template>

<script>

import { promotion } from '@/services';
import Swal from 'sweetalert2';

export default {
    name: "MontantPromotion",
    data() {
        return {
            promotion: {
                code: '',
                reduction: '',
                date_debut: '',
                date_fin: '',
                montant: '',
            },
            errors: [],
        };
    },
    methods: {
        addMontantPromotion() {
            console.log(this.promotion);
            promotion.createMontantPromotion(this.promotion).then((response) => {
                if(response.status == 201 || response.status == 200){
                    Swal.fire(
                        'Creer',
                        'Promotion creer avec success !',
                        'success'
                    )
                    // this.$router.push('/admin/dashboard')
                }
            } )
        }
    },
}
</script>

<style lang="scss" scoped></style>
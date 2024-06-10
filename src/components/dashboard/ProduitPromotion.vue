<template>
    <CCol :xs="12">
        <CCard class="mb-4">
            <CCardHeader>
                <strong>Ajouter un nouveau code promo</strong>
            </CCardHeader>
            <CCardBody>
                <CForm @submit.prevent="addPromo">
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
                    <CRow>
                        <CCol :md="6">
                            <div class="mb-2">
                                <CFormLabel for="produit">Produit</CFormLabel>
                                <CFormSelect id="produit" v-model="promotion.idProduit">
                                    <option v-for="item in produits" :key="item.id" :value="item.id"> {{ item.nom }}
                                    </option>
                                </CFormSelect>
                            </div>
                        </CCol>
                    </CRow>
                    <div class="col-auto">
                        <CButton color="success" type="submit">Creer</CButton>
                    </div>
                </CForm>
            </CCardBody>
        </CCard>
    </CCol>

</template>

<script>

import { produit, promotion } from '@/services';
import Swal from 'sweetalert2';

export default {
    name: "ProduitPromotion",
    data() {
        return {
            promotion: {
                code: '',
                reduction: '',
                date_debut: '',
                date_fin: '',
                idProduit: '',
            },
            errors: [],
            produits: [],
        };
    },
    mounted() {
        produit.allProduit(1, 500).then((response) => {
            this.produits = response.data.produits
        })
    },
    methods: {
        addPromo() {
            console.log(this.promotion);
            this.errors = [];
            promotion.createProduitPromotion(this.promotion).then((response) => {
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
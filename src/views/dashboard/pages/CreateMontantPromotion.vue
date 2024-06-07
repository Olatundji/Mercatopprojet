<template>
  <!-- Ligne des erreurs -->
  <div v-if="errors.length > 0">
    <ul>
      <li v-for="(item, index) in errors" :key="index">{{ item.message }}</li>
    </ul>
  </div>
  <CRow>
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
                  <CFormInput required v-model="promotion.code" id="code" type="text" placeholder="PROMO2024" />
                </div>
              </CCol>
              <CCol :md="6">
                <div class="mb-2">
                  <CFormLabel for="reduction">Réduction (%)</CFormLabel>
                  <CFormInput required v-model="promotion.reduction" id="reduction" type="number" placeholder="20" />
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
                  <CFormInput required v-model="promotion.montant" id="montant" type="number" placeholder="20" />
                </div>
              </CCol>
            <div class="col-auto">
              <CButton color="success" type="submit">Ajouter</CButton>
            </div>
          </CForm>
        </CCardBody>
      </CCard>
    </CCol>
  </CRow>
</template>

<script>
import router from '../../../router';
import {promotion } from '../../../services';

export default {
  name: "CreateMontantPromotion",
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
      this.errors = [];
      let formData = new FormData();
      formData.append('code', this.promotion.code);
      formData.append('reduction', this.promotion.reduction);
      formData.append('date_debut', this.promotion.date_debut);
      formData.append('date_fin', this.promotion.date_fin);
      formData.append('montant', this.promotion.montant);

      promotion.CreateMontantPromotion(formData).then(response => {
        console.log(response);
        if (response.status === 201) {
          alert('Promotion créée avec succès');
          router.push({name: `Promotion par montant`}); // Redirige vers la liste des promotions
        }
      }).catch(error => {
        console.error("Error creating promotion: ", error);
        this.errors = error.response?.data.errors || [{ message: 'Une erreur est survenue' }];
      });
    }
  },
}
</script>

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
          <CForm @submit.prevent="addPromo">
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
            <CRow>
              <CCol :md="6">
                <div class="mb-2">
                                    <CFormLabel for="produit">Produit</CFormLabel>
                                    <CFormSelect  id="produit" v-model="promotion.idProduit">
                                        <option  v-for="item in produit" :key="item.id" :value="item.id">  {{ item.nom }} </option>
                                    </CFormSelect>
                                </div>
                            </CCol>
            </CRow>
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
import { produit, promotion } from '../../../services'; // Assurez-vous que les services sont correctement importés

export default {
  name: "CreatePromotion",
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
      produit: [],
    };
  },
  mounted() {
    produit.allProduit().then((response) => {
            this.produit = response.data.produit
        })
  },
  methods: {
    addPromo() {
      this.errors = [];
      let formData = new FormData();
      formData.append('code', this.promotion.code);
      formData.append('reduction', this.promotion.reduction);
      formData.append('date_debut', this.promotion.date_debut);
      formData.append('date_fin', this.promotion.date_fin);
      formData.append('idProduit', this.promotion.idProduit);

      promotion.CreatePromotion(formData).then(response => {
        console.log(response);
        if (response.status === 201) {
          alert('Promotion créée avec succès');
          router.push('/promotions'); // Redirige vers la liste des promotions
        }
      }).catch(error => {
        console.error("Error creating promotion: ", error);
        this.errors = error.response?.data.errors || [{ message: 'Une erreur est survenue' }];
      });
    }
  },
}
</script>

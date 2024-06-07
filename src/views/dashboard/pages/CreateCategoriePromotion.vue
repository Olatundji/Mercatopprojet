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
                                    <CFormLabel for="categorie">Categorie</CFormLabel>
                                    <CFormSelect required v-model="promotion.idCategorie" aria-label="Default select example" id="categorie">
                                        <option v-for="(item, index) in categories" :key="index"  :value="item.id"> {{ item.libelle }} </option>
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
import { categorie, promotion } from '../../../services';

export default {
  name: "CreateCategoriePromotion",
  data() {
    return {
      promotion: {
        code: '',
        reduction: '',
        date_debut: '',
        date_fin: '',
        idCategorie: '',
      },
      errors: [],
      categories: [],
    };
  },
  mounted() {
        categorie.allCategorie().then((response) => {
            this.categories = response.data.categories
        })
  },
  methods: {
  addPromo() {
    this.errors = [];

    console.log("Promotion Data:", this.promotion);

    let formData = new FormData();
    formData.append('code', this.promotion.code);
    formData.append('reduction', this.promotion.reduction);
    formData.append('date_debut', this.promotion.date_debut);
    formData.append('date_fin', this.promotion.date_fin);
    formData.append('idCategorie', this.promotion.idCategorie);

    promotion.createCategoriePromotion(formData).then(response => {
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

<template>
    <!-- Ligne des erreurs -->
    <div v-if="errors.length > 0">
        <ul>
            <li v-for="(item, index) in errors" :key="index">{{ item.message }}</li>
        </ul>
    </div>
    <CRow>
        <CCol :md="6">
            <h3>Créer un nouvelle promotion</h3>
        </CCol>

        <CCol :md="6">
            <CFormSelect v-model="type_promo" class="form-control" id="type_promo" >
                <option value="1">Catégorie</option>
                <option value="2">Marque</option>
                <option value="3">Montant</option>
                <option value="4">Produit</option>
            </CFormSelect>
        </CCol>
    </CRow>

    <CRow  class="mt-3" v-if="type_promo == 1" >
        <CategoriePromotion></CategoriePromotion>
    </CRow>

    <CRow class="mt-3" v-if="type_promo == 2" >
        <MarquePromotion></MarquePromotion>
    </CRow>

    <CRow class="mt-3" v-if="type_promo == 3" >
        <MontantPromotion></MontantPromotion>
    </CRow>

    <CRow class="mt-3" v-if="type_promo == 4">
        <ProduitPromotion></ProduitPromotion>
    </CRow>
</template>

<script>

import MontantPromotion from '@/components/dashboard/MontantPromotion.vue';
import CategoriePromotion from '@/components/dashboard/CategoriePromotion.vue';
import MarquePromotion from '@/components/dashboard/MarquePromotion.vue';
import ProduitPromotion from '@/components/dashboard/ProduitPromotion.vue';

export default {
    name: "CreatePromotion",
    components: {
        MontantPromotion, CategoriePromotion, MarquePromotion, ProduitPromotion 
    },
    data() {
        return {
            type_promo: '1',
            errors: [],
        };
    },
    methods: {


    },
}
</script>
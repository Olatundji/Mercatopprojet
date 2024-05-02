<template>
    <CModal :visible="visibleModal" @close="() => { visibleModal = false }">
        <CForm>
            <CModalHeader dismiss @close="() => {
                visibleModal = false
            }
                ">
                <CModalTitle>Modifier les informations d'un produit</CModalTitle>
            </CModalHeader>
            <CModalBody>

                <CRow>
                    <CCol :md="6">
                        <div class="mb-2">
                            <CFormLabel for="nom">Nom</CFormLabel>
                            <CFormInput v-model="produit.nom" id="nom" type="text" placeholder="Barcelet Guici" />
                        </div>
                    </CCol>
                    <CCol :md="6">
                        <div class="mb-2">
                            <CFormLabel for="prix">Prix en (FCFA)</CFormLabel>
                            <CFormInput v-model="produit.prix" id="prix" type="number" placeholder="5000" />
                        </div>
                    </CCol>
                </CRow>
                <div class="mb-2">
                    <CFormLabel for="description">Description</CFormLabel>
                    <CFormTextarea placeholder="C'est un bracelet premium fait en or massif"
                        v-model="produit.description" id="description" rows="3"></CFormTextarea>
                </div>
                <CRow>
                    <CCol :md="6">
                        <div class="mb-2">
                            <CFormLabel for="marque">Marque</CFormLabel>
                            <CFormSelect id="marque" v-model="produit.marque_id" aria-label="Default select example">
                                <option>Open this select menu</option>
                                <option value="1">Gucuci</option>
                                <option value="1">Nike</option>
                            </CFormSelect>
                        </div>
                    </CCol>
                    <CCol :md="6">
                        <div class="mb-2">
                            <CFormLabel for="categorie">Categorie</CFormLabel>
                            <CFormSelect v-model="produit.categorie_id" aria-label="Default select example"
                                id="categorie">
                                <option>Open this select menu</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </CFormSelect>
                        </div>
                    </CCol>
                </CRow>
                <CRow>
                    <CCol :md="6">
                        <div class="mb-2">
                            <CFormLabel for="qte">Quantité</CFormLabel>
                            <CFormInput v-model="produit.qte" id="qte" type="number" placeholder="5" />
                        </div>
                    </CCol>
                    <CCol :md="6">
                        <div class="mb-2">
                            <CFormLabel for="image">Image</CFormLabel>
                            <CFormInput id="image" accept=".png, .jpg, .jpeg" @change="handleFileChange" type="file"
                                placeholder="Barcelet Guici" />
                        </div>
                    </CCol>
                </CRow>
            </CModalBody>
            <CModalFooter>
                <CButton color="secondary" @click="() => {
                    visibleModal = false
                }
                    ">
                    Close
                </CButton>
                <CButton type="submit" color="primary">Save changes</CButton>
            </CModalFooter>
        </CForm>
    </CModal>
    <CRow>
        <CTable caption="top">
            <CTableCaption>Liste des produits</CTableCaption>
            <CTableHead>
                <CTableRow>
                    <CTableHeaderCell scope="col">Numéro</CTableHeaderCell>
                    <CTableHeaderCell scope="col">Id Transaction</CTableHeaderCell>
                    <CTableHeaderCell scope="col">Methode de payement</CTableHeaderCell>
                    <CTableHeaderCell scope="col">Montant</CTableHeaderCell>
                    <CTableHeaderCell scope="col">Date</CTableHeaderCell>
                    <CTableHeaderCell scope="col">Etat</CTableHeaderCell>
                </CTableRow>
            </CTableHead>
            <CTableBody>
                <CTableRow>
                    <CTableDataCell>185FC64</CTableDataCell>
                    <CTableDataCell>7893652205</CTableDataCell>
                    <CTableDataCell>Strype</CTableDataCell>
                    <CTableDataCell>20500 </CTableDataCell>
                    <CTableDataCell> 25-10-2024 </CTableDataCell>
                    <CTableDataCell>
                        <label class="switch">
                            <ToggleSwitch :etat="etat1" :id="1" @update:etat="true" />
                        </label>
                    </CTableDataCell>
                </CTableRow>
                <CTableRow>
                    <CTableDataCell>185FC64</CTableDataCell>
                    <CTableDataCell>7893652205</CTableDataCell>
                    <CTableDataCell>Strype</CTableDataCell>
                    <CTableDataCell>20500 </CTableDataCell>
                    <CTableDataCell> 25-10-2024 </CTableDataCell>
                    <CTableDataCell>
                        <label class="switch">
                            <ToggleSwitch :etat="etat2" :id="2" @update:etat="!etat2" />
                        </label>
                    </CTableDataCell>
                </CTableRow>
                <CTableRow>
                    <CTableDataCell>185FC64</CTableDataCell>
                    <CTableDataCell>7893652205</CTableDataCell>
                    <CTableDataCell>Momo Pay</CTableDataCell>
                    <CTableDataCell>20500 </CTableDataCell>
                    <CTableDataCell> 25-10-2024 </CTableDataCell>
                    <CTableDataCell>
                        <label class="switch">
                            <ToggleSwitch :etat="etat3" :id="3" @update:etat="!etat3" />
                        </label>
                    </CTableDataCell>
                </CTableRow>
                <CTableRow>
                    <CTableDataCell>185FC64</CTableDataCell>
                    <CTableDataCell>7893652205</CTableDataCell>
                    <CTableDataCell>Momo Pay</CTableDataCell>
                    <CTableDataCell>20500 </CTableDataCell>
                    <CTableDataCell> 25-10-2024 </CTableDataCell>
                    <CTableDataCell>
                        <label class="switch">
                            <ToggleSwitch :etat="etat4" :id="4" @update:etat="!etat4" />
                        </label>
                    </CTableDataCell>
                </CTableRow>
            </CTableBody>
        </CTable>
    </CRow>
</template>

<script>

import ToggleSwitch from '@/components/ToggleSwitch.vue';
import { ref } from 'vue';
export default {
    components: {
        'ToggleSwitch': ToggleSwitch
    },
    name: "ListeCommande",
    setup() {
        const visibleModal = ref(false)
        return { visibleModal }
    },
    data() {
        return {
            etat1: false,
            etat2: true,
            etat3: true,
            etat4: false
        }
    },
    methods: {
    },
}
</script>

<style scoped></style>
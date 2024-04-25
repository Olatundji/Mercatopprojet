<template>
    <CRow>
        <CCol :xs="12">
            <CCard class="mb-4">
                <CCardHeader>
                    <strong>Ajouter vos produits ici</strong>
                </CCardHeader>
                <CCardBody>
                    <CForm @submit.prevent="addProduit" >
                        <div class="mb-2">
                            <CFormLabel for="nom">Nom</CFormLabel>
                            <CFormInput v-model="produit.nom" id="nom" type="text" placeholder="Barcelet Guici" />
                        </div>
                        <div class="mb-2">
                            <CFormLabel for="description">Description</CFormLabel>
                            <CFormTextarea placeholder="C'est un bracelet premium fait en or massif" v-model="produit.description" id="description" rows="4"></CFormTextarea>
                        </div>
                        <div class="mb-2">
                            <CFormLabel for="prix">Prix</CFormLabel>
                            <CFormInput v-model="produit.prix"  id="prix" type="number" placeholder="5" />
                        </div>
                        <div class="mb-2">
                            <CFormLabel for="nom">Image</CFormLabel>
                            <CFormInput accept=".png, .jpg, .jpeg"  @change="handleFileChange" id="nom" type="file" placeholder="Barcelet Guici" />
                        </div>
                        <div class="col-auto">
                            <CButton type="submit" class="bg-success"> Ajouter </CButton>
                        </div>
                    </CForm>
                </CCardBody>
            </CCard>
        </CCol>
    </CRow>
</template>

<script>

export default {
    name: "CreateProduit",
    data() {
        return {
            produit: {
                nom: "",
                qte: "",
                description: "",
                image: "",
                prix: ""
            }
        }
    },
    methods: {
        handleFileChange(event){
            console.log(event.target.files[0]);
        },
        addProduit(){
            console.log(this.produit);
        }
    },
}

</script>

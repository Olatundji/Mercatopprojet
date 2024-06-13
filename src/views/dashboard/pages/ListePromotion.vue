<template>
    <CRow>
        <CTable caption="top">
            <CTableCaption>Liste des promotion</CTableCaption>
            <CTableHead>
                <CTableRow>
                    <CTableHeaderCell scope="col">#</CTableHeaderCell>
                    <CTableHeaderCell scope="col">Code</CTableHeaderCell>
                    <CTableHeaderCell scope="col">Réduction</CTableHeaderCell>
                    <CTableHeaderCell scope="col">Date de debut</CTableHeaderCell>
                    <CTableHeaderCell scope="col">Date de fin</CTableHeaderCell>
                    <CTableHeaderCell class="center">Action</CTableHeaderCell>
                </CTableRow>
            </CTableHead>
            <CTableBody>
                <CTableRow v-for="(item,index) in promotions" :key="item.id" >
                    <CTableDataCell> {{ index + 1 }} </CTableDataCell>
                    <CTableDataCell> {{ item.code }} </CTableDataCell>
                    <CTableDataCell> {{ item.reduction }} </CTableDataCell>
                    <CTableDataCell> {{ item.date_debut }} </CTableDataCell>
                    <CTableDataCell> {{ item.date_fin }} </CTableDataCell>
                    <CTableDataCell>
                        <CButton @click="deletePromotion(item.id)" color="danger"> Supprimer</CButton>
                    </CTableDataCell>
                </CTableRow>
            </CTableBody>
        </CTable>
    </CRow>
</template>

<script>

import { promotion } from '@/services'
import Swal from 'sweetalert2';

export default {
    mounted() {
        promotion.allPromotion().then((response) => {
            this.promotions = response.data
        }).catch((error) => {
            console.log(error);
        } )
    },
    data() {
        return {
            promotions: []
        }
    },
    methods: {
        deletePromotion(id){
            Swal.fire({
                title: 'Êtes vous sûr?',
                text: "Ce code promo sera supprimé" ,
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, supprimer!',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    promotion.deletePromotion(id).then((response) => {
                        if (response.status == 200) {
                            Swal.fire(
                                'Supprimé !',
                                'Le code promo a bien été supprimé',
                                'success'
                            ).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload()
                                }
                            })
                        }
                    })
                }
            })
        },
    },
}
</script>

<style lang="scss" scoped>

</style>
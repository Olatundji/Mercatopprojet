<template>
    <CRow>
        <CTable caption="top">
            <CTableCaption>Liste des utilisateurs</CTableCaption>
            <CTableHead>
                <CTableRow>
                    <CTableHeaderCell scope="col">#</CTableHeaderCell>
                    <CTableHeaderCell scope="col">Nom</CTableHeaderCell>
                </CTableRow>
            </CTableHead>
            <CTableBody>
                <CTableRow v-for="(item,index) in users.noms_utilisateurs" :key="item.id" >
                    <CTableDataCell> {{ index + 1 }} </CTableDataCell>
                    <CTableDataCell> {{ item.nom }} </CTableDataCell>
                </CTableRow>
            </CTableBody>
        </CTable>
    </CRow>
</template>


<script>

import {statistique} from '@/services'

    export default {
        name: "ListeUtilisateur",
        mounted() {
            statistique.listeUser().then((response) => {
                this.users = response.data
                this.total_utilisateurs = response.data.total_utilisateurs
                console.log(response);
            } )
        },
        data() {
            return {
                users: [],
                total_utilisateurs: 0
            }
        },
    }
</script>

<style lang="scss" scoped>

</style>
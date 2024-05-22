<template>
    <TheHeader></TheHeader>
    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <h1 class="page-name">Dashboard</h1>
                        <ol class="breadcrumb">
                            <li><router-link to="/">Home</router-link></li>
                            <li class="active">commandes</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="user-dashboard page-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="dashboard-wrapper user-dashboard">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID commande</th>
                                        <th>Date</th>
                                        <th>Nombre de produits</th>
                                        <th>Montant</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#45123165</td>
                                        <td>Mar 25, 2024</td>
                                        <td>4</td>
                                        <td>9952XOF</td>
                                        <td><span class="label label-primary">Processing</span></td>
                                        <td><a href="order.html" class="btn btn-default">View</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <TheFooter></TheFooter>
</template>

<script>
import TheHeader from '../../components/client/TheHeader.vue';
import TheFooter from '../../components/client/TheFooter.vue';

    export default {
        components: {
            TheHeader, TheFooter
        }
    }
</script>

<style scoped>

</style>
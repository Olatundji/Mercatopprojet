<template>
    <TheHeader></TheHeader>

    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <h1 class="page-name">Dashboard</h1>
                        <ol class="breadcrumb">
                            <li><a href="index.html">Home</a></li>
                            <li class="active">profile</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <button class="custom-button" @click="openModal">Changer le mot de passe</button>

    <div v-if="isModalOpen" class="modal-custom" @click="closeModalOutside">
        <div class="modal-content">
            <span class="close" @click="closeModal">&times;</span>
            <h2>Changer le mot de passe</h2>
            <form @submit.prevent="changePassword">
                <div class="form-group">
                    <input v-model="password.newPassword" type="password" class="form-control" placeholder="Nouveau mot de passe">
                </div>
                <div class="form-group">
                    <input v-model="password.passwordConfirm" type="password" class="form-control" placeholder="Confirmer le mot de passe">
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-success">Se connecter</button>
                </div>
            </form>
        </div>
    </div>

    <section class="user-dashboard page-wrapper">
        <div class="container">
            <div class="row">
                <div class="police dashboard-wrapper dashboard-user-profile">
                    <div class="media">
                        <div class="pull-left text-center" href="#!">
                            <img class="media-object user-img" src="@/assets/images/avater.jpg" alt="Image">
                            <button class="btn btn-success mt-20">Modifier informations</button>
                        </div>
                        <div class="media-body ">
                            <div class="media-body">
                                <ul>
                                    <li>
                                        <div class="form-group">
                                            <label for="nom">Nom:</label>
                                            <input class="form-control" type="text" v-model="user.nom" >
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-group">
                                            <label for="email">Email:</label>
                                            <input class="form-control" type="text" v-model="user.email" >
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-group">
                                            <label for="numero">Numéro:</label>
                                            <input class="form-control" type="text" v-model="user.numero">
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <TheFooter></TheFooter>

</template>



<script>

import TheHeader from '@/components/client/TheHeader'
import TheFooter from '@/components/client/TheFooter'

export default {
    name: 'UserProfile',
    components: {
        TheHeader, TheFooter
    },
    data() {
        return {
            isModalOpen: true,
            user: {
                nom: '',
                email: '',
                numero: '',
            },
            password: {
                newPassword: '',
                passwordConfirm: ''
            }
        }
    },
    methods: {
        closeModalOutside(event) {
            if (event.target.classList.contains('modal-custom')) {
                this.closeModal();
            }
        },
        
        openModal() {
            this.isModalOpen = true;
        },

        closeModal() {
            this.isModalOpen = false;
        },

        changePassword() {
            console.log(this.password);
            this.closeModal();
        }
    },
}
</script>

<style scoped>


.custom-button{
    background-color: #f1e253;
    border: none;
    margin: 10px;
    color: #000000;
    padding: 15px 30px;
    border-radius: 10px;
}

.modal-custom {
    display: flex;
    position: fixed;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 30%;
    height: 40%;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

.police{
    font-size: 14px;
}

</style>
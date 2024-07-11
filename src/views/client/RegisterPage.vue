<template>
    <section class="signin-page account">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="block text-center">
                        <a class="logo" href="index.html">
                            <!-- <img src="@/assets/images/logo.png" alt=""> -->
                            <h2>MERCATO</h2>
                        </a>
                        <h2 class="text-center">Créer un compte</h2>
                        <div class="error">
                            <p>Il y a des errors dans le formulaire</p>
                        </div>
                        <form @submit.prevent="register" class="text-left clearfix">
                            <div class="form-group">
                                <input v-model="user.nom" type="text" class="form-control" placeholder="Nom">
                            </div>
                            <div class="form-group">
                                <input v-model="user.email" type="email" class="form-control" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <input v-model="user.numero" type="text" class="form-control" placeholder="Numéro">
                            </div>
                            <div class="form-group">
                                <input v-model="user.adresse" type="text" class="form-control" placeholder="Adresse">
                            </div>
                            <div class="form-group password-container">
                                <input v-model="user.password" :type="isPasswordVisible ? 'text' : 'password'" class="form-control"
                                    placeholder="Password">
                                    <font-awesome-icon @click="togglePasswordVisibility"
                                    :icon="isPasswordVisible ? 'eye-slash' : 'eye'" class="password-toggle" />
                            </div>
                            <div class="form-group password-container">
                                <small v-if="haveError" class="erreur" > {{ message }} </small>
                                <input v-model="passwordConfirm" :type="isPasswordVisible ? 'text' : 'password'" class="form-control"
                                    placeholder="Password Confirm">
                                <font-awesome-icon @click="togglePasswordVisibility"
                                    :icon="isPasswordVisible ? 'eye-slash' : 'eye'" class="password-toggle" />
                                
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-register text-center">S'inscrire</button>
                            </div>
                        </form>
                        <p class="mt-20">Vous avez déjà un compte ? <router-link to="/login"> Connecter-vous
                            </router-link> </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>


import router from "../../router";
import { auth } from "../../services";
import Swal from 'sweetalert2';

export default {
    name: 'RegisterPage',
    data() {
        return {
            user: {
                nom: '',
                email: '',
                numero: '',
                password: '',
                adresse: '',
            },
            passwordConfirm: '',
            errors: [],
            haveError: false,
            message: '',
            isPasswordVisible: false,
        }
    },

    methods: {
        togglePasswordVisibility() {
            this.isPasswordVisible = !this.isPasswordVisible;
        },
        register() {
            if (this.user.password == this.passwordConfirm) {
                auth.register(this.user).then((response) => {
                    console.log(response);
                    if (response.status == 200) {
                        Swal.fire(
                            'Envoyer ',
                            'Email envoyer avec success',
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                router.push({ name: `Login` })
                            }
                        })
                    }
                }).catch((error) => {
                    console.log(error);
                    if (error.response.status == 500) {
                        Swal.fire(
                            'Erreur ',
                            "Une erreur s'est produite lors de l'inscription",
                            'error'
                        )
                    }
                })
            } else {
                this.haveError = true
                this.message = "Les mots de passe ne sont pas identiques"
            }

        }
    },
}
</script>

<style scoped>

.btn-register{
    background-color: greenyellow;
    width: 30%;
    padding: 10px;
    border-radius: 10px;
}
.erreur {
    color: red;
}

.password-container {
    position: relative;
    width: 100%;
}

.password-container input {
    width: 100%;
    padding-right: 40px;
}

.password-toggle {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
}
</style>
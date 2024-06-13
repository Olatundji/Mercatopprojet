<template>
    <section class="signin-page account">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="block text-center">
                        <a class="logo" href="index.html">
                            <img src="@/assets/images/logo.png" alt="">
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
                            <div class="form-group">
                                <input v-model="user.password" type="password" class="form-control"
                                    placeholder="Password">
                            </div>
                            <div class="form-group">
                                <input v-model="passwordConfirm" type="password" class="form-control"
                                    placeholder="Password Confirm">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-main text-center">S'inscrire</button>
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
            haveError: true
        }
    },

    methods: {
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
                })
            } else {
                const error = { message: "Les mots de passes ne sont pas identique" }
                this.errors.push(error)
            }

        }
    },
}
</script>

<style scoped>
.error {
    background-color: red;
}
</style>
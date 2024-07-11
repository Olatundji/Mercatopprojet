<template>
    <section class="forget-password-page account">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="block text-center">
                        <a class="logo" href="index.html">
                            <h2>MERCATO</h2>
                        </a>
                        <h2 class="text-center">Heureux de vous revoir ! </h2>
                        <form @submit.prevent="forgotPassword" class="text-left clearfix">
                            <p>Veuillez saisir l'adresse électronique de votre compte. Un lien de vérification vous sera envoyé.
                                Une fois que vous aurez reçu le lien de vérification, vous pourrez choisir un nouveau mot de passe
                                pour votre compte.</p>
                                <div class="form-group">
                                    <input v-model="email" type="email" class="form-control"
                                        placeholder="Exp: test105mail@gmail.com" required>
                                        <small v-show="message.length > 1" class="erreur"> {{ message }} </small>
                                </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-send text-center">Mot de passe oublié</button>
                            </div>
                        </form>
                        <p class="mt-20"><router-link class="retour" to="/login">Retour sur la page de connexion </router-link></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import { auth } from '../../services';
import router from '../../router'
import Swal from 'sweetalert2';

export default {
    name: "ForgotPassword",
    data() {
        return {
            email: '',
            message: '',
        }
    },
    methods: {
        forgotPassword(){
            this.message = ""
            auth.forgotPassword(this.email).then((response) => {
                console.log(response);
                if(response.status == 200){
                    Swal.fire(
                                'Envoyé ! ',
                                'Consulter votre boite email !',
                                'success'
                            ).then((result) => {
                                if (result.isConfirmed) {
                                    router.push({name: `Login`})
                                }
                            })
                    
                }
            } ).catch((error) => {
                if(error.response.status == 404){
                    this.message = "L'adresse email est introvable"
                }
            } )
        },
    },

}
</script>

<style lang="scss" scoped>

.erreur{
    color: red;
}

.retour{
    background-color: rgb(240, 240, 240);
    border-radius: 20px;
    padding: 10px;
}

.btn-send{
    background-color: greenyellow;
    width: 30%;
    border-radius: 10px;
}

</style>
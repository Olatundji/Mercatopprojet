<template>
    <section v-if="isTokenValid == true" class="signin-page account">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="block text-center">
                        <a class="logo" href="index.html">
                            <!-- <img src="@/assets/images/logo.png" alt=""> -->
                            <h2>MERCATO</h2>
                        </a>
                        <h2 class="text-center">Réinitialisation de votre mot de passe</h2>
                        <p v-if="errors != null" > {{ errors }} </p>
                        <form @submit.prevent="resetPassword" class="text-left clearfix">
                            <div class="form-group password-container">
                                <input v-model="newPassword" :type="isPasswordVisible ? 'text' : 'password'" class="form-control"
                                    placeholder="Password">
                                    <font-awesome-icon @click="togglePasswordVisibility"
                                    :icon="isPasswordVisible ? 'eye-slash' : 'eye'" class="password-toggle" />
                            </div>
                            <div class="form-group password-container">
                                <small v-if="haveError" class="erreur" > {{ message }} </small>
                                <input v-model="confirmPassword" :type="isPasswordVisible ? 'text' : 'password'" class="form-control"
                                    placeholder="Password Confirm">
                                <font-awesome-icon @click="togglePasswordVisibility"
                                    :icon="isPasswordVisible ? 'eye-slash' : 'eye'" class="password-toggle" />
                                
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-change text-center">Changer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div v-else>
        <p>Le lien de réinitialisation est invalide ou a expiré.</p>
    </div>
</template>

<script>

import { auth } from "../../services";
import router from "@/router";
import "vue-toastification/dist/index.css";
import { useToast } from "vue-toastification";
import Swal from "sweetalert2";

export default {
    data() {
        return {
            isTokenValid: false,
            newPassword: '',
            confirmPassword: '',
            isPasswordVisible: false,
            haveError: false, 
            message: '',
            token: ''
        }
    },
    beforeRouteEnter(to, from, next) {
        const { token } = to.query
        if (!token) {
            next({ name: 'Accueil' })
        }
        console.log(token);
        
        auth.verifyToken(token).then((response) => {
            console.log(token);
            console.log(response);
            next(vm => {
                vm.token = token
                console.log(response);
                vm.isTokenValid = response.data.isTokenValid
            })
        }).catch((error) => {
            // eslint-disable-next-line no-unused-vars
            console.log(token);
            console.log(error);
                if(error.response.status == 500 || error.response.status == 404){
                    router.push({ name: 'Accueil' })
                }
            const toast = useToast();
            toast.error(error.response.data.messages.error, {
                timeout: 2000
            });
        })
    },
    methods: {
        togglePasswordVisibility() {
            this.isPasswordVisible = !this.isPasswordVisible;
        },
        resetPassword(){
            if(this.newPassword == this.confirmPassword){
                auth.resetPassword(this.newPassword,this.token).then((response) => {
                    console.log(response);
                    if(response.status == 200){
                        Swal.fire(
                                'Envoyé ! ',
                                'Mot de passe réinitialiser avec success ! Connecter-vous avec vos nouveau identifiant',
                                'success'
                            ).then((result) => {
                                if (result.isConfirmed) {
                                    router.push({name: `Login`})
                                }
                            })
                    }
                }).catch((error) => {
                    console.log(error);
                })
            }
            else{
                this.haveError = true
                this.message = "Les mots de passe ne sont pas identiques"
            }
        }
    },
}
</script>

<style lang="scss" scoped>

.btn-change{
    background-color: greenyellow;
    width: 30%;
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
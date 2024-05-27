<template>
    <section class="signin-page account">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="block text-center">
                        <a class="logo" href="index.html">
                            <img src="@/assets/images/logo.png" alt="">
                        </a>
                        <h2 class="text-center">Welcome Back</h2>
                        <p v-if="errors != null" > {{ errors }} </p>
                        <form @submit.prevent="login" class="text-left clearfix">
                            <div class="form-group">
                                <input v-model="user.email" type="email" class="form-control" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <input v-model="user.password" type="password" class="form-control" placeholder="Password">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-main text-center">Se connecter</button>
                            </div>
                        </form>
                        <p class="mt-20">Nouveau sur notre site ? <router-link to="/register"> S'inscrire </router-link> </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import { auth } from '../../services';
import store from '../../store';

export default {
    name: 'LoginPage',
    data() {
        return {
            user: {
                email: '',
                password: ''
            },
            errors: null,
        }
    },

    methods: {
        login() {
            auth.login(this.user).then((response) => {
                const token = response.data.token;
                const type = response.data.user.user_type;
                const user = response.data.user;
                store.commit('setToken', token)
                store.commit('setType', type)
                store.commit('setUser', user)
                if(type == 'user'){
                    this.$router.push('/')
                } else if( type == 'admin'){
                    this.$router.push('/admin/dashboard')
                }
            }).catch((error) => {
                if(error.response.status == 401){
                    // console.log(error.response.data.error);
                    this.errors = error.response.data.error
                }
            })
        },
        logout(){
            
        }
    },
}
</script>

<style scoped>
.error {
    background-color: red;
}
</style>
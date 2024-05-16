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
                        <p class="mt-20">Nouveau sur notre site ?<a href="/register"> Crer un compte</a></p>
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
            errors: [],
        }
    },

    methods: {
        login() {
            console.log(this.user);
            auth.login(this.user).then((response) => {
                const token = response.data.token;
                const type = response.data.user.user_type;
                const user = response.data.user;
                store.commit('setToken', token)
                store.commit('setType', type)
                store.commit('setUser', user)
                this.$router.push('/')
                console.log(response);
            })
        }
    },
}
</script>

<style scoped>
.error {
    background-color: red;
}
</style>
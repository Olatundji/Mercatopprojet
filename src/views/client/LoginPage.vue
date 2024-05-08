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
                        <form @submmit.prevent="login" class="text-left clearfix">
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
                        <p class="mt-20">New in this site ?<a href=""> Crer un compte</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: 'RegisterPage',
    data() {
        return {
            user: {
                email: '',
                password: ''
            },
            passwordConfirm: '',
            errors: [],
        }
    },

    methods: {
        login() {
            console.log(this.user);
        }
    },
}
</script>

<style scoped>
.error {
    background-color: red;
}
</style>
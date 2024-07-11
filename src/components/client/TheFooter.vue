<template>
    <footer class="footer section text-center ">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="footer-menu text-uppercase">
                        <li>
                            <router-link class="footer-link" to="/produits"> Shop </router-link>
                        </li>
                        <li>
                            <router-link class="footer-link" to="/produits"> Blog </router-link>
                        </li>
                        <li>
                            <a class="footer-link" href="#">PRIVACY POLICY</a>
                        </li>
                    </ul>
                    <p class="copyright-text"><span> Copyright </span> &copy; <span>2024, Designed</span> &amp;
                        <span>Developed by</span> <a href="https://speedtech.me/">Speed-tech</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>
</template>

<script>

export default {
    name: 'TheFooter'
}
</script>

<style>
.footer-link:hover{
    text-decoration: underline;
}

.footer {
    background-color: rgb(44, 43, 43);
}

a {
    text-decoration: none;
}
</style>

<template>
    <section class="top-header">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-xs-12 col-sm-4">
                    <div class="contact-number">
                        <i class="tf-ion-ios-telephone"></i>
                        <span>229- 68685-949</span>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12 col-sm-4">
                    <div class="one">
                        <h1>MERCATO</h1>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12 col-sm-4">
                    <ul class="top-menu text-right list-inline">
                        <li class="dropdown cart-nav dropdown-slide">
                            <a href="#"><i class="tf-ion-android-cart"></i>Cart <span class="badge">4</span> </a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="menu">
        <nav class="navbar navigation">
            <div class="container-navbar">
                <div class="navbar-header">
                    <h2 class="menu-title">Main Menu</h2>
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>

                <!-- Navbar Links -->
                <div id="navbar" class="navbar-collapse collapse container-nav ">
                    <ul class="nav navbar-nav">

                        <li class="dropdown ">
                            <a href="#">Accueil</a>
                        </li>

                        <li class="dropdown ">
                            <a href="#">Nos articles</a>
                        </li>

                        <li class="dropdown ">
                            <a href="#">Mon compte</a>
                        </li>

                        <li @mouseenter="visible = true" @mouseleave="visible = false" class="dropdown hover-effet">
                            <a class="dropdown-toggle" href="#">S'authentifier</a>
                            <div v-show="visible" class="auth">
                                <a href="" class="btn-item">Se connecter </a>
                                <hr>
                                <a href="" class="btn-item">S'inscrire </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </section>
</template>

<script>
export default {
    name: 'TheHeader',
    data() {
        return {
            visible: false
        }
    },
    methods: {
        toggleElement(event) {
            console.log(event);
            this.visible = !this.visible
        }
    },
}
</script>

<style >
a {
    text-decoration: none;
}

.badge {
    background-color: red;
    color: white;
    padding: 4px 8px;
    text-align: center;
    border-radius: 5px;
}

.one h1 {
    text-align: center;
    text-transform: uppercase;
    padding-bottom: 5px;
}

.one h1:before {
    width: 28px;
    height: 5px;
    display: block;
    content: "";
    position: absolute;
    bottom: 3px;
    left: 50%;
    margin-left: -14px;
    background-color: #b80000;
}

.one h1:after {
    width: 100px;
    height: 1px;
    display: block;
    content: "";
    position: relative;
    margin-top: 25px;
    left: 50%;
    margin-left: -50px;
    background-color: #b80000;
}

h1 {
    position: relative;
    padding: 0;
    margin: 0;
    font-family: "Raleway", sans-serif;
    font-weight: 300;
    font-size: 40px;
    color: #080808;
    -webkit-transition: all 0.4s ease 0s;
    -o-transition: all 0.4s ease 0s;
    transition: all 0.4s ease 0s;
}

.footer {
    background: rgb(75, 71, 71);
    padding: 50px 0;
}

.btn-item {
    color: black;
    padding: 5px;
    border-radius: 3px;
    margin: 5px;
    background-color: white;
}

.btn-item:hover {
    padding: 5px;
    border-radius: 3px;
    margin: 5px;
    background-color: black;
    color: white;
}


.hover-effet {
    position: relative;
    height: 100%;
}

.hover-effet:hover .auth {
    display: block;
}



.auth {
    padding: 10px;
    position: absolute;
    height: 50px;
    background-color: white;
    border: 1px solid white;
    border-radius: 15px;
    width: 10%;
    height: 70px;
}

.auth a:hover {
    display: flex;
    background-color: rgb(32, 31, 31);
}

</style>

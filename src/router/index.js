// import { h, resolveComponent } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'

import  { authGuard }  from '@/services/auth-guard.js'
import DefaultLayout from '@/layouts/DefaultLayout'
import ProfilePage from '@/views/dashboard/pages/Profile.vue'
import LoginAdmin from '@/views/dashboard/pages/Login.vue'
import CreateProduit from '@/views/dashboard/pages/CreateProduit.vue'
import ListProduit from '@/views/dashboard/pages/ListProduit.vue'
import ListeCommande from '@/views/dashboard/pages/ListeCommande.vue'
import Categorie from '@/views/dashboard/pages/Categorie.vue'
import Marque from '@/views/dashboard/pages/Marque.vue'
import MaBoutique from '@/views/dashboard/pages/MaBoutique.vue'
import CreateArticle from '@/views/dashboard/pages/CreateArticle.vue'
import ListeArticle from '@/views/dashboard/pages/ListeArticle.vue'
import Welcome from '@/views/client/Welcome.vue'
import RegisterPage from '@/views/client/RegisterPage.vue'
import LoginPage from '@/views/client/LoginPage.vue'
import UserProfile from '@/views/client/UserProfile.vue'
import ShopPage from '@/views/client/ShopPage.vue'
import CommandePage from '@/views/client/CommandePage.vue'
import DetailsProduit from '../views/client/DetailsProduit.vue'
import CartPage from '@/views/client/CartPage.vue'
import CheckoutPage from '@/views/client/CheckoutPage.vue'

const routes = [
  {
    path: '/admin/dashboard',
    meta: {requireAuth: true, type:'admin'},
    name: 'Home',
    component: DefaultLayout,
    redirect: '/admin/dashboard',
    children: [
      {
        path: '/admin/dashboard',
        name: 'Dashboard',
        component: () => import('@/views/dashboard/Dashboard.vue'),
      },
      {
        path: '/admin/profile',
        meta: {requireAuth: true, type:'admin'},
        name: 'Profile',
        component: ProfilePage ,
      },
      {
        path: "/admin/produit-create",
        name: 'CreateProduit',
        meta: {requireAuth: true, type:'admin'},
        component: CreateProduit
      },
      {
        path: "/admin/produits-list",
        name: "Liste des Produits",
        meta: {requireAuth: true, type:'admin'},
        component: ListProduit
      },
      {
        path: "/admin/commandes", 
        name: "AdminCommandes",
        meta: {requireAuth: true, type:'admin'},
        component: ListeCommande
      },
      {
        path: "/admin/liste-categorie",
        name: "CategorieListe",
        meta: {requireAuth: true, type:'admin'},
        component: Categorie
      },
      {
        path: "/admin/liste-marque",
        name: "Marque",
        meta: {requireAuth: true, type:'admin'},
        component: Marque
      },
      {
        path: "/admin/boutique",
        name: "Ma Boutique",
        meta: {requireAuth: true, type:'admin'},
        component: MaBoutique
      },
      {
        path: "/admin/liste-article",
        name: "Liste des articles",
        meta: {requireAuth: true, type:'admin'},
        component: ListeArticle
      },
      {
        path: "/admin/article-create",
        name: "Publier un article ",
        meta: {requireAuth: true, type:'admin'},
        component: CreateArticle
      },
    ]
  },
  {
    path: '/admin/login',
    name: 'LoginAdmin',
    component: LoginAdmin,
  },
  {
    path: '/',
    name: 'Accueil',
    component: Welcome,
  },
  {
    path: '/register',
    name: 'Register',
    component: RegisterPage
  },
  {
    path: '/login',
    name: 'Login',
    component: LoginPage
  },
  {
    path: '/user/profile',
    name: 'Profile Utilisateur',
    meta: {requireAuth: true, type:'user'},
    component: UserProfile,
  },
  {
    path: '/produits',
    name: 'Liste des produits',
    component: ShopPage,
  },
  {
    path: '/produit/single',
    name: 'DetailsProduit',
    component: DetailsProduit,
  },
  {
    path: '/user/cart',
    name: 'CartList',
    component: CartPage,
  },
  {
    path: '/user/commandes', 
    meta: {requireAuth: true, type:'user'},
    name: "UserCommandes",
    component: CommandePage,
  },
  {
    path: '/user/checkout', 
    name: "UserCommandes",
    component: CheckoutPage,
  },
  {
    path: '/:pathMatch(.*)*',redirect: '/'
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior() {
    return { top: 0 }
  },
})


router.beforeEach((to,from,next)=>{
  if(to.meta.requireAuth && to.meta.type == 'admin'){
      authGuard('admin')
  }
  if(to.meta.requireAuth && to.meta.type == 'user')
  {
      authGuard('user')
  }
  next()
})

export default router

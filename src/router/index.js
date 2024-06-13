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
import CategorieArticle from '../views/dashboard/pages/CategorieArticle.vue'
import FavorisPage from '../views/client/FavorisPage.vue'
import BlogPage from '../views/client/Blog/BlogPage.vue'
import ShowArticle from '../views/client/Blog/ShowArticle.vue'
import SearchPage from '../views/client/SearchPage.vue'
import CreatePromotion from '../views/dashboard/pages/CreatePromotion.vue'
import ListePromotion from '../views/dashboard/pages/ListePromotion.vue'
import ListeUtilisateur from '../views/dashboard/pages/ListeUtilisateur.vue'

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
      {
        path: "/admin/liste/categorie-article",
        name: "Liste des catégorie d'article",
        meta: {requireAuth: true, type:'admin'},
        component: CategorieArticle
      },
      {
        path: "/admin/create-promotion",
        name: "Create Promotion",
        meta: {requireAuth: true, type:'admin'},
        component: CreatePromotion,
      },
      {
        path: "/admin/list-promotion",
        name: "Liste Promotion",
        meta: {requireAuth: true, type:'admin'},
        component: ListePromotion,
      },
      {
        path: "/admin/user-list",
        name: "Liste des utilisateurs",
        meta: {requireAuth: true, type:'admin'},
        component: ListeUtilisateur,
      }
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
    path: '/blog',
    name: 'BlogPage',
    component: BlogPage,
  },
  {
    path: '/blog/single',
    name: 'BlogSingle',
    component: ShowArticle,
  },
  {
    path: '/user/favoris',
    name: 'Favoris',
    component: FavorisPage,
    meta: {requireAuth: true, type:'user'},
  },
  {
    path: '/user/cart',
    name: 'CartList',
    component: CartPage,
    meta: {requireAuth: true, type:'user'}
  },
  {
    path: '/user/search',
    name: 'SearchPage',
    component: SearchPage,
  },
  {
    path: '/user/commandes', 
    meta: {requireAuth: true, type:'user'},
    name: "UserCommandes",
    component: CommandePage,
  },
  {
    path: '/user/checkout', 
    name: "CheckoutPage",
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

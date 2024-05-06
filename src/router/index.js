// import { h, resolveComponent } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'

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

const routes = [
  {
    path: '/admin/dashboard',
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
        name: 'Profile',
        component: ProfilePage ,
      },
      {
        path: "/admin/produit-create",
        name: 'CreateProduit',
        component: CreateProduit
      },
      {
        path: "/admin/produits-list",
        name: "Liste des Produits",
        component: ListProduit
      },
      {
        path: "/admin/commandes", 
        name: "Commandes",
        component: ListeCommande
      },
      {
        path: "/admin/liste-categorie",
        name: "Categorie",
        component: Categorie
      },
      {
        path: "/admin/liste-marque",
        name: "Marque",
        component: Marque
      },
      {
        path: "/admin/boutique",
        name: "Ma Boutique",
        component: MaBoutique
      },
      {
        path: "/admin/article-create", // /admin/liste/categorie-article
        name: "Publier un article ",
        component: CreateArticle
      },
      {
        path: "/admin/liste/liste-article",
        name: "Liste des articles",
        component: ListeArticle
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
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior() {
    return { top: 0 }
  },
})

export default router

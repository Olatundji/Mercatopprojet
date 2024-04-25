// import { h, resolveComponent } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'

import DefaultLayout from '@/layouts/DefaultLayout'
import ProfilePage from '@/views/dashboard/pages/Profile.vue'
import LoginAdmin from '@/views/dashboard/pages/Login.vue'
import CreateProduit from '@/views/dashboard/pages/CreateProduit.vue'

const routes = [
  {
    path: '/admin',
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
        path: '/admin-profile',
        name: 'Profile',
        component: ProfilePage ,
      },
      {
        path: "/produit-create",
        name: 'CreateProduit',
        component: CreateProduit
      },
    ]
  },
  {
    path: '/admin/login',
    name: 'LoginAdmin',
    component: LoginAdmin,
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

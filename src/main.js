
import "./assets/plugins/themefisher-font/style.css"
import "./assets/plugins/bootstrap/css/bootstrap.min.css"
import "./assets/plugins/animate/animate.css"
import "./assets/plugins/slick/slick.css"
import "./assets/plugins/slick/slick-theme.css"
import "./assets/css/style.css"

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
// import Vuelidate from '@vuelidate/core'

import CoreuiVue from '@coreui/vue'
import CIcon from '@coreui/icons-vue'
import { iconsSet as icons } from '@/assets/icons'
import DocsExample from '@/components/DocsExample'

const app = createApp(App)
app.use(store)
app.use(router)
app.use(CoreuiVue)
app.provide('icons', icons)
app.component('CIcon', CIcon)
app.component('DocsExample', DocsExample)

app.mount('#app')

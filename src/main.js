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

import CoreuiVue from '@coreui/vue'
import CIcon from '@coreui/icons-vue'
import { iconsSet as icons } from '@/assets/icons'
import DocsExample from '@/components/DocsExample'
import Toast from "vue-toastification";

import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { fas } from '@fortawesome/free-solid-svg-icons';

library.add(fas);

const app = createApp(App)

app.use(store)
app.use(router)
app.use(CoreuiVue)
app.use(Toast)
app.provide('icons', icons)
app.component('CIcon', CIcon)
app.component('DocsExample', DocsExample)
app.component('font-awesome-icon', FontAwesomeIcon);

app.mount('#app')

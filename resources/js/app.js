import { createApp, markRaw } from 'vue'
import { createPinia } from 'pinia'

import App from './components/app.vue'
import router from './router'
import ElementPlus from 'element-plus'
import BootstrapVue3 from 'bootstrap-vue-3'
import createPersistedState from 'pinia-plugin-persistedstate'

import "bootstrap"
import 'bootstrap/dist/css/bootstrap.min.css'
import '@fortawesome/fontawesome-free/css/all.min.css'
//import 'bootstrap/dist/js/bootstrap.bundle'
import 'element-plus/dist/index.css'

const pinia = createPinia()
pinia.use(({store}) => {
    store.router = markRaw(router)
})

pinia.use(createPersistedState)

const app = createApp(App)
app.use(pinia)
app.use(ElementPlus)
app.use(BootstrapVue3)
app.use(router)

app.mount('#app')

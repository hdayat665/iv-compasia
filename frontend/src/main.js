import { createApp } from 'vue'
import { createPinia } from 'pinia'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'

import App from './App.vue'
import router from './router'

const app = createApp(App)

const pinia = createPinia()  // ✅ simpan instance
app.use(pinia)               // ✅ pasang instance
app.use(router)

app.mount('#app')

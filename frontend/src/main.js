import './assets/main.css'
import { createApp } from 'vue'
import { createPinia } from 'pinia'
import ToastPlugin from 'vue-toast-notification';
import VueApexCharts from 'vue3-apexcharts'
import 'vue-toast-notification/dist/theme-bootstrap.css';

// Initialize Vue app
import App from './App.vue'
import router from './router'

const app = createApp(App)
app.use(VueApexCharts)
app.use(createPinia())
app.use(ToastPlugin);
app.use(router)
app.mount('#app')

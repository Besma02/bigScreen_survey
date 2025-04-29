import './style.css'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import store from './store';
const app = createApp(App)

app.use(Toast, { position: "bottom-right", timeout: 3000 }).use(router).use(store);

app.mount('#app')

import './bootstrap.js';

import router from './router/index.js';
import { createApp } from 'vue';
import App from './App.vue';
import '../css/app.css';
const app = createApp(App);
app.use(router);
app.config.globalProperties.$URL_API = import.meta.env.VITE_U_LIST_API_URL;
app.mount('#app');

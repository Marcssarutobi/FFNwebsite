import './bootstrap';
import { createApp } from 'vue';
import App from './components/App.vue';
import router from './components/router';
import '@fortawesome/fontawesome-free/css/all.min.css';


const app = createApp(App);
app.use(router);
app.mount('#app');

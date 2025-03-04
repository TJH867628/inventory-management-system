import { createApp } from 'vue';
import Login from './components/Login.vue';
import '@fontsource/inter';

const app = createApp(Login);
app.component('my-page-component', Login);
app.mount('#app');
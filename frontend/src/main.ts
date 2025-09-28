import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import { createPinia } from 'pinia';
import 'vuetify/styles';
import { createVuetify } from 'vuetify';
import '@mdi/font/css/materialdesignicons.css';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// const vuetify = createVuetify();




// 1. Import Vuetify essentials
import 'vuetify/styles'; // Import the main styles

import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';
import '@mdi/font/css/materialdesignicons.css'; // Import MDI icons

// 2. Create the Vuetify instance
const vuetify = createVuetify({
  components,
  directives,
  // Add other configurations like theme, icons, etc. here
  icons: {
    defaultSet: 'mdi',
  },
});




// Configure Laravel Echo + Pusher
window.Pusher = Pusher;
window.Echo = new Echo({
  broadcaster: 'pusher',
  key: 'your-pusher-key',           
  cluster: 'your-pusher-cluster',   
  forceTLS: true,
  authEndpoint: 'http://localhost:8000/broadcasting/auth',
  auth: {
    headers: {
      Authorization: `Bearer ${localStorage.getItem('token')}`,
    },
  },
});

const app = createApp(App);
app.use(router);
app.use(createPinia());
app.use(vuetify);
app.mount('#app');

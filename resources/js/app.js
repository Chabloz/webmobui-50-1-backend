import { createApp } from 'vue';
import { Quasar } from 'quasar';
import '@quasar/extras/roboto-font/roboto-font.css';
import '@quasar/extras/material-icons/material-icons.css';
import 'quasar/dist/quasar.css';

import App from './AppChat.vue';

// Example data that come directly from the Laravel blade template
console.log(BACK_DATA);

const myApp = createApp(App);

myApp.use(Quasar, {
  plugins: {},
  config: {
    brand: {
      negative: 'tomato',
    },
    dark: 'auto'
  }
});

myApp.mount('#app');
import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import vuetify from './plugins/vuetify'
import axios from 'axios'
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import anime from 'animejs/lib/anime.es.js';

require('vue2-animate/dist/vue2-animate.min.css')
Vue.use(VueToast);
Vue.config.productionTip = false

new Vue({
  router,
  store,
  vuetify,
  axios,
  render: function (h) { return h(App) }
}).$mount('#app')

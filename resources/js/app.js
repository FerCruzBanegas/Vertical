import Vue from 'vue'
import Vuetify from 'vuetify'
import Snotify from 'vue-snotify'
import currency from 'v-currency-field'
import App from './App.vue'
import VueRouter from 'vue-router'
import router from './router'
import store from './store'
// import ApiService from './services/api.service'
// import { TokenService } from './services/storage.service'

const options = {
  toast: {
    timeout: 4000,
    showProgressBar: true,
    closeOnClick: true,
    pauseOnHover: true,
    icon: '/img/icon.png'
  }
}

Vue.use(Vuetify)
Vue.use(Snotify, options)
Vue.use(VueRouter)
Vue.use(currency)
Vue.filter('formatDate', require('./filters/formatDate'));
Vue.filter('currency', require('./filters/currency'));

// ApiService.init()

// if (TokenService.getToken()) {
//   ApiService.setHeader()
// }

const app = new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App)
});

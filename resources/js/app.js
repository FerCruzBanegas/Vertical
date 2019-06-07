import Vue from 'vue'
import Vuetify from 'vuetify'
import currency from 'v-currency-field'
import App from './App.vue'
import VueRouter from 'vue-router'
import router from './router'
import store from './store'
import ApiService from './services/api.service'
import { TokenService } from './services/storage.service'


Vue.use(Vuetify)
Vue.use(VueRouter)
Vue.use(currency)
Vue.filter('formatDate', require('./filters/formatDate'));

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

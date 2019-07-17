import Vue from 'vue'
import Snotify from 'vue-snotify'
import Vuetify from 'vuetify'
import currency from 'v-currency-field'
import App from './App.vue'
import VueRouter from 'vue-router'
import router from './router'
import store from './store'
import ApiService from './services/api.service'
import { TokenService } from './services/storage.service'

Vue.use(Snotify)
Vue.use(Vuetify)
Vue.use(VueRouter)
Vue.use(currency)
Vue.filter('formatDate', require('./filters/formatDate'));
Vue.filter('currency', require('./filters/currency'));
// ApiService.init()

// if (TokenService.getToken()) {
//   ApiService.setHeader()
// }

const EventBus = new Vue()

Object.defineProperties(Vue.prototype, {
  $bus: {
    get: function () {
      return EventBus
    }
  }
})

const app = new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App)
});


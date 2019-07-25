import Vue from 'vue'
import Snotify from 'vue-snotify'
import VeeValidate from 'vee-validate'
import VueValidationEs  from 'vee-validate/dist/locale/es';
import Vuetify from 'vuetify'
import currency from 'v-currency-field'
import App from './App.vue'
import VueRouter from 'vue-router'
import router from './router'
import store from './store'
import ApiService from './services/api.service'
import { TokenService } from './services/storage.service'

Vue.use(Snotify);
Vue.use(VeeValidate, {
  locale: 'es',
  dictionary: {
    es: VueValidationEs
  }
});
Vue.use(Vuetify);
Vue.use(VueRouter);
Vue.use(currency);
Vue.filter('formatDate', require('./filters/formatDate'));
Vue.filter('currency', require('./filters/currency'));
// ApiService.init()

// if (TokenService.getToken()) {
//   ApiService.setHeader()
// }

Vue.prototype.$setErrorsFromResponse = function(errorResponse) {
  if(!this.hasOwnProperty('$validator')) {
    return;
  }
    
  function addErrorToChildComponents(vm,field,errorString) {
	if(vm && vm.$validator && vm.$validator.errors){
	  const inputfield = vm.$validator.fields.find({ name: field });
	  if(inputfield){
	  vm.$validator.errors.add({
	    field,
	    msg:errorString
	  });
	    return;
	  }
	}
	if(vm.$children){
	  vm.$children.map(async ($cvm) => {
	    addErrorToChildComponents($cvm,field,errorString);
	  });
	}
	return;
  }

  this.$validator.errors.clear();

  if(!errorResponse.hasOwnProperty('errors')) {
    return;
  }

  let errorFields = Object.keys(errorResponse.errors);

  errorFields.map(field => {
    let errorString = errorResponse.errors[field].join(', ');
    addErrorToChildComponents(this,field,errorString);     
  });
};

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


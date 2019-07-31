import Vue from 'vue'
import Vuex from 'vuex'
import auth from './modules/auth'
import message from './modules/message'
import createPersistedState from 'vuex-persistedstate'

Vue.use(Vuex)

export default new Vuex.Store({
  modules:{
    auth,
    message
  },
  plugins: [createPersistedState()]
})

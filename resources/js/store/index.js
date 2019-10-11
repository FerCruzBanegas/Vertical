import Vue from 'vue'
import Vuex from 'vuex'
import auth from './modules/auth'
import message from './modules/message'
import income from './modules/income'
import expense from './modules/expense'
import boxes from './modules/boxes'
import createPersistedState from 'vuex-persistedstate'

Vue.use(Vuex)

export default new Vuex.Store({
  modules:{
    auth,
    message,
    income,
    expense,
    boxes
  },
  plugins: [createPersistedState()]
})

import IncomeService from '../../services/income.service'

// state
const state = {
  itemsIn: [],
  modalIn: false,
  showIn: false
}

// mutations
const mutations = {
  OPEN_MODAL_IN (state) {
    state.modalIn = true;
    state.showIn = true;
  },

  GET_ITEMS_IN (state, data) {
    state.itemsIn = data;
  },

  CLOSE_MODAL_IN (state) {
    state.modalIn = false;
    state.showIn = false;
    state.itemsIn = [];
  }
}

// actions
const actions = {
  async openLastIncome({ commit }, data) {
    try {
      commit('OPEN_MODAL_IN')
      const res = await IncomeService.getIncomes('incomes/last');
      if (res.status === 200) {
        commit('GET_ITEMS_IN', res.data.data)
      }
    } catch (e) { throw e }
  },

  closeModalIncome ({ commit }) {
    commit('CLOSE_MODAL_IN')
  }
}

// getters
const getters = {
  openLastIncome: state => {
    return { ...state }
  },

  incomes: (state) => {
    return state.itemsIn
  }
}

export default {
  state,
  mutations,
  actions,
  getters
}

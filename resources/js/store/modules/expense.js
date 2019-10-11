import ExpenseService from '../../services/expense.service'

// state
const state = {
  itemsEx: [],
  modalEx: false,
  showEx: false
}

// mutations
const mutations = {
  OPEN_MODAL_EX (state) {
    state.modalEx = true;
    state.showEx = true;
  },

  GET_ITEMS_EX (state, data) {
    state.itemsEx = data;
  },

  CLOSE_MODAL_EX (state) {
    state.modalEx = false;
    state.showEx = false;
    state.itemsEx = [];
  }
}

// actions
const actions = {
  async openLastExpense({ commit }, data) {
    try {
      commit('OPEN_MODAL_EX')
      const res = await ExpenseService.getExpenses('expenses/last');
      if (res.status === 200) {
        commit('GET_ITEMS_EX', res.data.data)
      }
    } catch (e) { throw e }
  },

  closeModalExpense ({ commit }) {
    commit('CLOSE_MODAL_EX')
  }
}

// getters
const getters = {
  openLastExpense: state => {
    return { ...state }
  },

  expenses: (state) => {
    return state.itemsEx
  }
}

export default {
  state,
  mutations,
  actions,
  getters
}

import SmallBoxService from '../../services/small.box.service'

// state
const state = {
  itemsBox: [],
  modalBox: false,
  showBox: false
}

// mutations
const mutations = {
  OPEN_MODAL_BOX (state) {
    state.modalBox = true;
    state.showBox = true;
  },

  GET_ITEMS_BOX (state, data) {
    state.itemsBox = data.map((obj) => { 
      let rObj = {}
      rObj['id'] = obj.id
      rObj['date_init'] = obj.date_init
      rObj['start_amount'] = obj.start_amount
      rObj['add_amount'] = obj.add_amount
      rObj['name'] = obj.name
      rObj['loading'] = false
      rObj['new_amount'] = 0
      return rObj
    });
  },

  CLOSE_MODAL_BOX (state) {
    state.modalBox = false;
    state.showBox = false;
    state.itemsBox = [];
  }
}

// actions
const actions = {
  async getSmallBoxesActives({ commit }, data) {
    try {
      commit('OPEN_MODAL_BOX')
      const res = await SmallBoxService.getSmallBoxes('small-boxes/actives');
      if (res.status === 200) {
        commit('GET_ITEMS_BOX', res.data)
      }
    } catch (e) { throw e }
  },

  closeModalSmallBox ({ commit }) {
    commit('CLOSE_MODAL_BOX')
  }
}

// getters
const getters = {
  getSmallBoxesActives: state => {
    return { ...state }
  },

  boxes: (state) => {
    return state.itemsBox
  }
}

export default {
  state,
  mutations,
  actions,
  getters
}

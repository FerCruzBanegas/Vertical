import ApiService from './api.service'

const SmallBoxService = {

  getSmallBoxes: async function(url) {
    try {
      const response = await ApiService.get(url)
      return response
    } catch (error) {
      console.log(error)
    }
  },

  deleteSmallBox: async function(url) {
    try {
      const response = await ApiService.delete(url)
      return response
    } catch (error) {
      console.log(error)
    }
  },

  storeSmallBox: async function(data) {
    try {
      const response = await ApiService.post('/small-boxes', data)
      return response
    } catch (error) {
      throw error
    }
  },

  updateSmallBox: async function(id, data) {
    try {
      const response = await ApiService.put(`small-boxes/${id}`, data)
      return response
    } catch (error) {
      throw error
    }
  },

  getExpenseSmallBox: async function(url, params) {
    try {
      const response = await ApiService.getParams(url, params)
      return response
    } catch (error) {
      console.log(error)
    }
  },
}

export default SmallBoxService

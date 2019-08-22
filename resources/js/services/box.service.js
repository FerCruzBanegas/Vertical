import ApiService from './api.service'

const BoxService = {

  getBoxes: async function(url) {
    try {
      const response = await ApiService.get(url)
      return response
    } catch (error) {
      console.log(error)
    }
  },

  deleteBox: async function(url) {
    try {
      const response = await ApiService.delete(url)
      return response
    } catch (error) {
      console.log(error)
    }
  },

  storeBox: async function(data) {
    try {
      const response = await ApiService.post('/boxes', data)
      return response
    } catch (error) {
      throw error
    }
  },

  updateBox: async function(id, data) {
    try {
      const response = await ApiService.put(`boxes/${id}`, data)
      return response
    } catch (error) {
      throw error
    }
  },
}

export default BoxService

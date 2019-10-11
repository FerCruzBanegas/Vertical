import ApiService from './api.service'

const AmountService = {

  getAmounts: async function(url) {
    try {
      const response = await ApiService.get(url)
      return response
    } catch (error) {
      console.log(error)
    }
  },

  deleteAmount: async function(url) {
    try {
      const response = await ApiService.delete(url)
      return response
    } catch (error) {
      console.log(error)
    }
  },

  storeAmount: async function(data) {
    try {
      const response = await ApiService.post('/amounts', data)
      return response
    } catch (error) {
      throw error
    }
  },

  updateAmount: async function(id, data) {
    try {
      const response = await ApiService.put(`amounts/${id}`, data)
      return response
    } catch (error) {
      throw error
    }
  },
}

export default AmountService

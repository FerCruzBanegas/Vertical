import ApiService from './api.service'

const IncomeTypeService = {

  getIncomeTypes: async function(url) {
    try {
      const response = await ApiService.get(url)
      return response
    } catch (error) {
      console.log(error)
    }
  },

  deleteIncomeType: async function(url) {
    try {
      const response = await ApiService.delete(url)
      return response
    } catch (error) {
      console.log(error)
    }
  },

  storeIncomeType: async function(data) {
    try {
      const response = await ApiService.post('/income-types', data)
      return response
    } catch (error) {
      console.log(error)
    }
  },

  updateIncomeType: async function(id, data) {
    try {
      const response = await ApiService.put(`income-types/${id}`, data)
      return response
    } catch (error) {
      console.log(error)
    }
  },
}

export default IncomeTypeService

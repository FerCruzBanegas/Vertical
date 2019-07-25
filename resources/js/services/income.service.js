import ApiService from './api.service'

const IncomeService = {

  getIncomes: async function(url) {
    try {
      const response = await ApiService.get(url)
      return response
    } catch (error) {
      console.log(error)
    }
  },

  deleteIncome: async function(url) {
    try {
      const response = await ApiService.delete(url)
      return response
    } catch (error) {
      console.log(error)
    }
  },

  storeIncome: async function(data) {
    try {
      const response = await ApiService.post('/incomes', data)
      return response
    } catch (error) {
      throw error
    }
  },

  updateIncome: async function(id, data) {
    try {
      const response = await ApiService.put(`incomes/${id}`, data)
      return response
    } catch (error) {
      throw error
    }
  },
}

export default IncomeService

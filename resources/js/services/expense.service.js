import ApiService from './api.service'

const ExpenseService = {

  getExpenses: async function(url) {
    try {
      const response = await ApiService.get(url)
      return response
    } catch (error) {
      console.log(error)
    }
  },

  deleteExpense: async function(url) {
    try {
      const response = await ApiService.delete(url)
      return response
    } catch (error) {
      console.log(error)
    }
  },

  storeExpense: async function(data) {
    try {
      const response = await ApiService.post('/expenses', data)
      return response
    } catch (error) {
      throw error
    }
  },

  updateExpense: async function(id, data) {
    try {
      const response = await ApiService.put(`expenses/${id}`, data)
      return response
    } catch (error) {
      throw error
    }
  },
}

export default ExpenseService

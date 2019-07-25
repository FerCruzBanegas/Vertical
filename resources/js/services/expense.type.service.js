import ApiService from './api.service'

const ExpenseTypeService = {

  getExpenseTypes: async function(url) {
    try {
      const response = await ApiService.get(url)
      return response
    } catch (error) {
      console.log(error)
    }
  },

  deleteExpenseType: async function(url) {
    try {
      const response = await ApiService.delete(url)
      return response
    } catch (error) {
      console.log(error)
    }
  },

  storeExpenseType: async function(data) {
    try {
      const response = await ApiService.post('/expense-types', data)
      return response
    } catch (error) {
      throw error
    }
  },

  updateExpenseType: async function(id, data) {
    try {
      const response = await ApiService.put(`expense-types/${id}`, data)
      return response
    } catch (error) {
      throw error
    }
  },
}

export default ExpenseTypeService

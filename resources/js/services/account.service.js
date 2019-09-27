import ApiService from './api.service'

const AccountService = {

  getAccounts: async function(url) {
    try {
      const response = await ApiService.get(url)
      return response
    } catch (error) {
      console.log(error)
    }
  },

  deleteAccount: async function(url) {
    try {
      const response = await ApiService.delete(url)
      return response
    } catch (error) {
      console.log(error)
    }
  },

  storeAccount: async function(data) {
    try {
      const response = await ApiService.post('/accounts', data)
      return response
    } catch (error) {
      throw error
    }
  },

  updateAccount: async function(id, data) {
    try {
      const response = await ApiService.put(`accounts/${id}`, data)
      return response
    } catch (error) {
      throw error
    }
  },

  changeState: async function(id) {
    try {
      const response = await ApiService.put(`accounts/${id}/state`)
      return response
    } catch (error) {
      throw error
    }
  },
}

export default AccountService

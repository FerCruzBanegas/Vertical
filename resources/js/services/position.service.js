import ApiService from './api.service'

const PositionService = {

  getPositions: async function(url) {
    try {
      const response = await ApiService.get(url)
      return response
    } catch (error) {
      console.log(error)
    }
  },

  storePosition: async function(data) {
    try {
      const response = await ApiService.post('/positions', data)
      return response
    } catch (error) {
      throw error
    }
  },
}

export default PositionService

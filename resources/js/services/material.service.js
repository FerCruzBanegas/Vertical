import ApiService from './api.service'

const MaterialService = {

  getMaterials: async function(url) {
    try {
      const response = await ApiService.get(url)
      return response
    } catch (error) {
      console.log(error)
    }
  },

  deleteMaterial: async function(url) {
    try {
      const response = await ApiService.delete(url)
      return response
    } catch (error) {
      console.log(error)
    }
  },

  storeMaterial: async function(data) {
    try {
      const response = await ApiService.post('/materials', data)
      return response
    } catch (error) {
      console.log(error)
    }
  },

  updateMaterial: async function(id, data) {
    try {
      const response = await ApiService.put(`materials/${id}`, data)
      return response
    } catch (error) {
      console.log(error)
    }
  },
}

export default MaterialService

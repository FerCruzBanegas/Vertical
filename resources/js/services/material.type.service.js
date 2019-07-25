import ApiService from './api.service'

const MaterialTypeService = {

  getMaterialTypes: async function(url) {
    try {
      const response = await ApiService.get(url)
      return response
    } catch (error) {
      console.log(error)
    }
  },

  deleteMaterialType: async function(url) {
    try {
      const response = await ApiService.delete(url)
      return response
    } catch (error) {
      console.log(error)
    }
  },

  storeMaterialType: async function(data) {
    try {
      const response = await ApiService.post('/material-types', data)
      return response
    } catch (error) {
      throw error
    }
  },

  updateMaterialType: async function(id, data) {
    try {
      const response = await ApiService.put(`material-types/${id}`, data)
      return response
    } catch (error) {
      throw error
    }
  },
}

export default MaterialTypeService

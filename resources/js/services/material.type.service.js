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
  }
}

export default MaterialTypeService

import ApiService from './api.service'

const ProfileService = {

  getProfiles: async function(url) {
    try {
      const response = await ApiService.get(url)
      return response
    } catch (error) {
      console.log(error)
    }
  },

  deleteProfile: async function(url) {
    try {
      const response = await ApiService.delete(url)
      return response
    } catch (error) {
      console.log(error)
    }
  },

  storeProfile: async function(data) {
    try {
      const response = await ApiService.post('/profiles', data)
      return response
    } catch (error) {
      throw error
    }
  },

  updateProfile: async function(id, data) {
    try {
      const response = await ApiService.put(`profiles/${id}`, data)
      return response
    } catch (error) {
      throw error
    }
  },
}

export default ProfileService

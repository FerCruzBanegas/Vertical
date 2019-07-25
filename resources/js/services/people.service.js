import ApiService from './api.service'

const PeopleService = {

  getPeople: async function(url) {
    try {
      const response = await ApiService.get(url)
      return response
    } catch (error) {
      console.log(error)
    }
  },

  deletePeople: async function(url) {
    try {
      const response = await ApiService.delete(url)
      return response
    } catch (error) {
      console.log(error)
    }
  },

  storePeople: async function(data) {
    try {
      const response = await ApiService.post('/people', data)
      return response
    } catch (error) {
      console.log(error)
    }
  },

  updatePeople: async function(id, data) {
    try {
      const response = await ApiService.put(`people/${id}`, data)
      return response
    } catch (error) {
      console.log(error)
    }
  },
}

export default PeopleService

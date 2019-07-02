import ApiService from './api.service'

const ProjectTypeService = {

  getProjectTypes: async function(url) {
    try {
      const response = await ApiService.get(url)
      return response
    } catch (error) {
      console.log(error)
    }
  },

  deleteProjectType: async function(url) {
    try {
      const response = await ApiService.delete(url)
      return response
    } catch (error) {
      console.log(error)
    }
  },

  storeProjectType: async function(data) {
    try {
      const response = await ApiService.post('/project-types', data)
      return response
    } catch (error) {
      console.log(error)
    }
  },

  updateProjectType: async function(id, data) {
    try {
      const response = await ApiService.put(`project-types/${id}`, data)
      return response
    } catch (error) {
      console.log(error)
    }
  },
}

export default ProjectTypeService

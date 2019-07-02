import ApiService from './api.service'

const ProjectService = {

  getProjects: async function(url) {
    try {
      const response = await ApiService.get(url)
      return response
    } catch (error) {
      console.log(error)
    }
  },

  deleteProject: async function(url) {
    try {
      const response = await ApiService.delete(url)
      return response
    } catch (error) {
      console.log(error)
    }
  },

  storeProject: async function(data) {
    try {
      const response = await ApiService.post('/projects', data)
      return response
    } catch (error) {
      console.log(error)
    }
  },

  updateProject: async function(id, data) {
    try {
      const response = await ApiService.put(`projects/${id}`, data)
      return response
    } catch (error) {
      console.log(error)
    }
  },
}

export default ProjectService

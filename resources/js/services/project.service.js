import ApiService from './api.service'

const ProjectTypeService = {

  getProjects: async function(url) {
    try {
      const response = await ApiService.get(url)
      return response
    } catch (error) {
      console.log(error)
    }
  }
}

export default ProjectTypeService

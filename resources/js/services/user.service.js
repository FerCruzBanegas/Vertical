import ApiService from './api.service'
import { TokenService } from './storage.service'


class AuthenticationError extends Error {
    constructor(errorCode, message) {
        super(message)
        this.name = this.constructor.name
        this.message = message
        this.errorCode = errorCode
    }
}

const UserService = {
  /**
   * Login the user and store the access token to TokenService. 
   * 
   * @returns access_token
   * @throws AuthenticationError 
  **/
  getUsers: async function(url) {
    try {
      const response = await ApiService.get(url)
      return response
    } catch (error) {
      console.log(error)
    }
  },

  deleteUser: async function(url) {
    try {
      const response = await ApiService.delete(url)
      return response
    } catch (error) {
      console.log(error)
    }
  },

  storeUser: async function(data) {
    try {
      const response = await ApiService.post('/users', data)
      return response
    } catch (error) {
      throw error
    }
  },

  updateUser: async function(id, data) {
    try {
      const response = await ApiService.put(`users/${id}`, data)
      return response
    } catch (error) {
      throw error
    }
  },

  changePassword: async function(id, data) {
    try {
      const response = await ApiService.put(`users/${id}/password`, data)
      return response
    } catch (error) {
      throw error
    }
  },

  login: async function(data) {
    try {
      const response = await ApiService.post('/login', data)
          
      TokenService.saveToken(response.data.access_token)
      TokenService.saveRefreshToken(response.data.refresh_token)
      // ApiService.setHeader()
      
      // // NOTE: We haven't covered this yet in our ApiService 
      // //       but don't worry about this just yet - I'll come back to it later
      // ApiService.mount401Interceptor();

      return response.data
    } catch (error) {
      throw error
    }
  },

  refreshToken: async function() {
    const refreshToken = TokenService.getRefreshToken()

    const data = { refresh_token: refreshToken }

    try {
      const response = await ApiService.post('/login', data)

      TokenService.saveToken(response.data.access_token)
      TokenService.saveRefreshToken(response.data.refresh_token)
      // Update the header in ApiService
      //ApiService.setHeader()

      return response.data.access_token
    } catch (error) {
      throw new AuthenticationError(error.response.status, error.response.data.detail)
    }
  },

  /**
   * Logout the current user by removing the token from storage. 
   * 
   * Will also remove `Authorization Bearer <token>` header from future requests.
  **/
  logout: async function() {
    // Remove the token and remove Authorization header from Api Service as well 
    try {
      const response = await ApiService.post('/logout')

      TokenService.removeToken()
      TokenService.removeRefreshToken()
      ApiService.removeHeader()

      return response
    } catch (error) {
      throw new AuthenticationError(error.response.status, error.response.data.detail)
    }
    // NOTE: Again, we'll cover the 401 Interceptor a bit later. 
    // ApiService.unmount401Interceptor()
  }
}

export default UserService

export { UserService, AuthenticationError }
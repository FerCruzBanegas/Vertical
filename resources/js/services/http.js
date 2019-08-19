import axios from 'axios'
import store from '../store'
import router from '../router'
import { TokenService } from './storage.service'
import { API_URL } from "./config"

let instance = axios.create({
  baseURL: API_URL
})

instance.interceptors.request.use((config) => {
  const token = TokenService.getToken()
  const csrf = document.head.querySelector('meta[name="csrf-token"]')

  if (token) {
  	config.headers['Authorization'] = `Bearer ${token}` 
  }

  if (csrf) {
    config.headers['X-CSRF-TOKEN'] = csrf.content
  } else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
  }

  config.headers['X-Requested-With'] = 'XMLHttpRequest'
  config.headers['Accept-Language'] = 'en'
  config.headers['Accept'] = 'application/json'

  return config
}, error => {
  return Promise.reject(error)
})

instance.interceptors.response.use(
  (response) => {
    return response
  }, error => {
    if (error.response.status === 401 && error.response.data.message == "Unauthenticated.") {
      store.dispatch('responseMessage', {
        type: 'warning',
        text: 'No tiene una sesión activa, por favor vuelva a iniciar sesión.',
        title: 'Sesión Expirada!',
        modal: true
      })
      .then(async () => {
        await store.dispatch('cleanSession')
        router.push({ name: 'Login' })
      })
    }

    if (error.response.status === 403) {
      router.push({ name: 'Unauthorized' })
    }

    if (error.response.status >= 500) {
      store.dispatch('responseMessage', {
        type: 'error',
        text: error.response.data.errors.message,
        title: 'Error',
        modal: true
      })
    }
    
    return Promise.reject(error)
})
// instance.interceptors.response.use(
//   (response) => {
//     return response
//   },
//   async (error) => {
// 	if (error.request.status == 401) {
// 	  if (error.config.url.includes('/login')) {
// 	    // El token de actualización ha fallado. Cerrar sesión del usuario
// 	    store.dispatch('logout')
// 	    throw error
// 	  } else {
// 	    // Actualizar el token de acceso
// 	    try{
// 	      await store.dispatch('refreshToken')
// 	      // Vuelva a intentar la solicitud original
// 	      return instance({
//             method: error.config.method,
//             url: error.config.url,
//             data: error.config.data
// 	      })
// 	    } catch (e) {
// 	      // La actualización ha fallado - rechace la solicitud original
// 	      throw error
// 	    }
// 	  }
// 	}
// 	// Si el error no fue 401 solo rechazar como está
// 	throw error
// })

// // response parse
// instance.interceptors.response.use((response) => {
//   return parseBody(response)
// }, error => {
//   console.warn('Error status', error.response.status)

//   if (error.response) {
//     return parseError(error.response.data)
//   } else {
//     return Promise.reject(error)
//   }
// })

export const http = instance
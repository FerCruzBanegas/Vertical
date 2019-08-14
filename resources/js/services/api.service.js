import { http } from './http'

const ApiService = {

    removeHeader() {
        http.defaults.headers.common = {}
    },

    get(resource) {
        return http.get(resource)
    },

    getParams(resource, data) {
        return http.get(resource, data)
    },

    post(resource, data) {
        return http.post(resource, data)
    },

    put(resource, data) {
        return http.put(resource, data)
    },

    delete(resource) {
        return http.delete(resource)
    },

    customRequest(data) {
        return http(data)
    },

    // _401interceptor: null,

    // mount401Interceptor() {
    //     this._401interceptor = axios.interceptors.response.use(
    //         (response) => {
    //             return response
    //         },
    //         async (error) => {
    //             if (error.request.status == 401) {
    //                 if (error.config.url.includes('/o/token/')) {
    //                     // El token de actualización ha fallado. Cerrar sesión del usuario
    //                     store.dispatch('auth/logout')
    //                     throw error
    //                 } else {
    //                     // Actualizar el token de acceso
    //                     try{
    //                         await store.dispatch('auth/refreshToken')
    //                         // Vuelva a intentar la solicitud original
    //                         return this.customRequest({
    //                             method: error.config.method,
    //                             url: error.config.url,
    //                             data: error.config.data
    //                         })
    //                     } catch (e) {
    //                         // La actualización ha fallado - rechace la solicitud original
    //                         throw error
    //                     }
    //                 }
    //             }

    //             // Si el error no fue 401 solo rechazar como está
    //             throw error
    //         }
    //     )
    // },

    // unmount401Interceptor() {
    //     // Expulsar el interceptor
    //     axios.interceptors.response.eject(this._401interceptor)
    // }

    /**
     * Realizar una solicitud personalizada de Axios.
     *
     * Los datos son un objeto que contiene las siguientes propiedades:
     *  - method
     *  - url
     *  - data ... request payload
     *  - auth (opcional)
     *    - username
     *    - password
    **/
}

export default ApiService
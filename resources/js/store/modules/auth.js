import { UserService, AuthenticationError } from '../../services/user.service'
import { TokenService } from '../../services/storage.service'
// import router from '../router'


const state =  {
    authenticating: false,
    accessToken: TokenService.getToken(),
    authenticationErrorCode: 0,
    authenticationError: '',
    refreshTokenPromise: null
}

const mutations = {
    loginRequest(state) {
        // state.authenticating = true;
        state.authenticationError = ''
        state.authenticationErrorCode = 0
    },

    loginSuccess(state, accessToken) {
        state.accessToken = accessToken
        state.authenticating = true;
    },

    loginError(state, {errorCode, errorMessage}) {
        state.authenticating = false
        state.authenticationErrorCode = errorCode
        state.authenticationError = errorMessage
    },

    logoutSuccess(state) {
        state.accessToken = ''
    },

    refreshTokenPromise(state, promise) {
        state.refreshTokenPromise = promise
    }
}

const actions = {
  async login({ commit }, data) {
    commit('loginRequest');

    try {
      const token = await UserService.login(data);

      commit('loginSuccess', token)

      return true
    } catch (e) {
      if (e instanceof AuthenticationError) {
        commit('loginError', {errorCode: e.errorCode, errorMessage: e.message})
      }

      return false
    }
  },

  logout({ commit }) {
    UserService.logout()
    commit('logoutSuccess')
    //router.push('/login')
  },

    refreshToken({ commit, state }) {
        // Si esta es la primera vez que se llama a refreshToken, haga una solicitud
        // de lo contrario devuelve la misma promesa a la persona que llama
        if(!state.refreshTokenPromise) {
            const p = UserService.refreshToken()
            commit('refreshTokenPromise', p)

            // Espere a que el UserService.refreshToken () se resuelva. En caso de éxito establecer el token y clara promesa
            // Borrar la promesa de error también.
            p.then(
                response => {
                    commit('refreshTokenPromise', null)
                    commit('loginSuccess', response)
                },
                error => {
                    commit('refreshTokenPromise', null)
                }
            )
        }

        return state.refreshTokenPromise
    }
}

const getters = {
    loggedIn: (state) => {
        return state.accessToken ? true : false
    },

    authenticationErrorCode: (state) => {
        return state.authenticationErrorCode
    },

    authenticationError: (state) => {
        return state.authenticationError
    },

    authenticating: (state) => {
        return state.authenticating
    }
}


export default {
  state,
  mutations,
  actions,
  getters
}

import { UserService, AuthenticationError } from '../../services/user.service'
import { TokenService } from '../../services/storage.service'
// import router from '../router'


const state =  {
  user: null,
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

  loginSuccess(state, data) {
    state.user = data.user
    state.accessToken = data.access_token
    state.authenticating = true;
  },

  loginError(state, {errorCode, errorMessage}) {
    state.authenticating = false
    state.authenticationErrorCode = errorCode
    state.authenticationError = errorMessage
  },

  logoutSuccess(state) {
    state.user = null
    state.accessToken = ''
    state.authenticating = false
  },

  refreshTokenPromise(state, promise) {
    state.refreshTokenPromise = promise
  }
}

const actions = {
  async login({ commit }, data) {
    commit('loginRequest');

    try {
      const res = await UserService.login(data);
      commit('loginSuccess', res)
      return true
    } catch (e) {
      if (e instanceof AuthenticationError) {
        commit('loginError', {errorCode: e.errorCode, errorMessage: e.message})
      }
      return false
    }
  },

  async logout ({ commit }) {
    try {
      const res = await UserService.logout()
      if (res.status === 200) {
        commit('logoutSuccess')
        return true
      } 
    } catch (e) { }
  },

  refreshToken({ commit, state }) {
    // Si esta es la primera vez que se llama a refreshToken, haga una solicitud
    // de lo contrario devuelve la misma promesa a la persona que llama
    if(!state.refreshTokenPromise) {
      const p = UserService.refreshToken()
      commit('refreshTokenPromise', p)

      // Espere a que el UserService.refreshToken () se resuelva. En caso de éxito establecer el token y clara promesa
      // Borrar la promesa de error también.
      p.then(response => {
        commit('refreshTokenPromise', null)
        commit('loginSuccess', response)
      },error => {
        commit('refreshTokenPromise', null)
      })
    }
    return state.refreshTokenPromise
  }
}

const getters = {
  currentUser: (state) => {
    return state.user
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

import VueRouter from 'vue-router'
import routes from './routes'
import store from '../store'

const router = new VueRouter({
  mode: 'history',
  linkActiveClass: 'active',
  routes
})

router.beforeEach((to, from, next) => {
  const requiresAuth = to.matched.some( record => record.meta.requiresAuth);
  const redirectIfLogged = to.matched.some(record => record.meta.redirectIfLogged);
  const authenticating = store.getters.authenticating;
  if (requiresAuth) {
    console.log(to)
    if (!authenticating) {
      next({
        path: '/login',
        query: { redirect: to.fullPath }
      })
    }
    if (to.name == 'Dashboard') {
      return next()
    }
    if ((store.getters.currentUser.acl !== null && store.getters.currentUser.acl.includes(to.meta.AccessControlList)) || store.getters.currentUser.acl.includes('*')) {
      next()
    } else {
      next({
        path: '/unauthorized'
      })
    }
  } else if (redirectIfLogged) {
    if (authenticating) {
      next({
        path: '/'
      })
    } else {
      next()
    }
  } else {
    next()
  }
})

export default router

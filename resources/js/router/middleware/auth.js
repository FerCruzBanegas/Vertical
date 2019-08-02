import store from '../../store'

export default (to, next, store) => {
  console.log(to)
  const requiresAuth = to.to.matched.some(record => record.meta.requiresAuth);
  const redirectIfLogged = to.matched.some(record => record.meta.redirectIfLogged );
  const authenticating = store.getters.authenticating;

  if (requiresAuth && !authenticating) {
    next({
      path: '/login',
      query: { redirect: to.fullPath }
    })
  } else if (redirectIfLogged && authenticating) {
    next({
      path: '/'
    })
  } else {
    next()
  }
}

import store from '../../store'

export default ( to, next, store ) => {
  if (store.getters.currentUser.acl.includes(to.meta.AccessControlList)) {
    next()
  } else {
    next({
      path: 'unauthorized'
    })
  }
}

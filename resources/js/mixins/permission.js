 import { mapGetters } from 'vuex'

export default {
    computed: mapGetters([
        'currentUser'
     ]),

    methods: {
        permission (url) {
            if(this.currentUser !== null)
                return this.currentUser.acl.includes(url) || this.currentUser.acl.includes('*')
        }
    }
}
import moment from 'moment'

moment.locale('es');

export default {
    methods: {
        curdate () {
            return moment(Date.now()).format('MMMM YYYY')
        }
    }
}
import Vue           from 'vue'
import Notifications from 'vue-notification'

Nova.booting((Vue, router, store) => {
    Vue.use(Notifications)
    Vue.component('index-account-contacts', require('./components/IndexField'))
    Vue.component('detail-account-contacts', require('./components/DetailField'))
    Vue.component('form-account-contacts', require('./components/FormField'))
})

import vSelect from 'vue-select'

Nova.booting((Vue, router, store) => {
    Vue.component('v-select', vSelect);
    
    Vue.component('index-belongs-to-with-type', require('./components/IndexField'))
    Vue.component('detail-belongs-to-with-type', require('./components/DetailField'))
    Vue.component('form-belongs-to-with-type', require('./components/FormField'))
})

Nova.booting((Vue, router, store) => {
    Vue.component('index-products-quantity', require('./components/IndexField'))
    Vue.component('detail-products-quantity', require('./components/DetailField'))
    Vue.component('form-products-quantity', require('./components/FormField'))
})

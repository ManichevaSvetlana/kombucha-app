import vSelect from 'vue-select'
import Vue from 'vue';
import VueSweetalert2 from 'vue-sweetalert2';

const options = {
    confirmButtonColor: '#41b882',
    cancelButtonColor: '#ff7674'
};

Nova.booting((Vue, router, store) => {
    Vue.component('v-select', vSelect);
    Vue.use(VueSweetalert2, options);
    router.addRoutes([
        {
            name: 'price-tracker',
            path: '/price-tracker',
            component: require('./components/Tool'),
        },
    ])
})

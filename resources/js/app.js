require('./bootstrap');

window.Vue = require('vue');
Vue.component('example-component', require('./components/ExampleComponent.vue').default);

import 'font-awesome/css/font-awesome.min.css'
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
Vue.use(Vuetify)

/**
 * templates
 */
Vue.component('sidebar', require('./components/templates/Sidebar').default);

/**
 * pages
 */
Vue.component('dashboard', require('./components/pages/Dashboard').default);

Vue.component('inventory-index', require('./components/pages/Inventory/Index').default);
Vue.component('inventory-create', require('./components/pages/Inventory/Create').default);
Vue.component('inventory-edit', require('./components/pages/Inventory/Edit').default);

Vue.component('vehicle-index', require('./components/pages/Vehicles/Index').default);
Vue.component('vehicle-create', require('./components/pages/Vehicles/Create').default);
Vue.component('vehicle-edit', require('./components/pages/Vehicles/Edit').default);

Vue.component('shipping-index', require('./components/pages/Shippings/Index').default);
Vue.component('shipping-create', require('./components/pages/Shippings/Create').default);
Vue.component('shipping-edit', require('./components/pages/Shippings/Edit').default);

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    icons: {},
    theme: {
        themes:{
            dark:{
                background: '#EEEEE',
            },
        },
    },
});

require('./bootstrap');

window.Vue = require('vue');
Vue.component('example-component', require('./components/ExampleComponent.vue').default);

import 'font-awesome/css/font-awesome.min.css'
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import * as VueGoogleMaps from 'vue2-google-maps'
import { Bar } from 'vue-chartjs'

Vue.use(Vuetify)
Vue.use(VueGoogleMaps, {
  load: {
    key: 'AIzaSyAiZc5IxkocC88d_ZIzBPf9jNn-X7XYRGI',
    libraries: 'places,directions',
  },
})

  
/**
 * templates
 */
Vue.component('sidebar', require('./components/templates/Sidebar').default);

/**
 * pages
 */
Vue.component('dashboard', require('./components/pages/Dashboard').default);
Vue.component('change-password', require('./components/pages/ChangePassword').default);
Vue.component('add-user', require('./components/pages/Users/Create').default);

Vue.component('inventory-index', require('./components/pages/Inventory/Index').default);
Vue.component('inventory-create', require('./components/pages/Inventory/Create').default);
Vue.component('inventory-edit', require('./components/pages/Inventory/Edit').default);

Vue.component('vehicle-index', require('./components/pages/Vehicles/Index').default);
Vue.component('vehicle-create', require('./components/pages/Vehicles/Create').default);
Vue.component('vehicle-edit', require('./components/pages/Vehicles/Edit').default);

Vue.component('shipping-index', require('./components/pages/Shippings/Index').default);
Vue.component('shipping-create', require('./components/pages/Shippings/Create').default);
Vue.component('shipping-edit', require('./components/pages/Shippings/Edit').default);

Vue.component('sales-index', require('./components/pages/Sales/Index').default);

Vue.component('map-index', require('./components/pages/Maps/Index').default);

Vue.component('category-index', require('./components/pages/Category/Index').default);
Vue.component('category-create', require('./components/pages/Category/Create').default);

Vue.component('order-create', require('./components/pages/Orders/Create').default);

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

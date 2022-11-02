require('./bootstrap');

window.Vue = require('vue');
Vue.component('example-component', require('./components/ExampleComponent.vue').default);

import 'font-awesome/css/font-awesome.min.css'
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
Vue.use(Vuetify)

Vue.component('sidebar', require('./components/templates/Sidebar.vue').default);

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    icons: {

    },
    theme: {
        themes:{
            dark:{
                background: '#EEEEE',
            }
        }
    }
});

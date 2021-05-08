require('./bootstrap');

window.Vue = require('vue')

import router from './router.js'

Vue.component('mainapp', require('./components/mainapp.vue').default)

const app = new Vue({
    el: '#app',
    router
})

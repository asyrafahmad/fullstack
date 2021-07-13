require('./bootstrap');
window.Vue = require('vue')
import router from './router.js'

// Import IView vue
import ViewUI from 'view-design';
import 'view-design/dist/styles/iview.css';
Vue.use(ViewUI);
// Import IView vue

Vue.component('mainapp', require('./components/mainapp.vue').default)

const app = new Vue({
    el: '#app',
    router
})

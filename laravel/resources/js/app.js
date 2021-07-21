

require('./bootstrap');
window.Vue = require('vue')

// Import router.js
import router from './router.js'
// Import router.js

// Import IView vue
import ViewUI from 'view-design';
import 'view-design/dist/styles/iview.css';
Vue.use(ViewUI);
// Import IView vue

// Import common.js
import common from './common.js'
Vue.mixin(common)
// Import common.js

// Import store.js
import store from'./store.js'
// Import store.js

Vue.component('mainapp', require('./components/mainapp.vue').default)

const app = new Vue({
    el: '#app',
    router,
    store
})

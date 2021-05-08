import Vue from 'vue'
import Router from 'vue-router'


Vue.use(Router)


import firstPage from './components/pages/myFirstVuePage'
import newRoutePage from './components/pages/newRoutePage'
import hooks from './components/pages/basic/hooks.vue'

const routes = [
    {
        path: '/my-new-vue-route',
        name: 'my-new-vue-route',
        component: firstPage,
    },
    {
        path: '/new-route',
        name: 'new-route',
        component: newRoutePage
    },

    //vue hooks
    {
        path: '/hooks',
        name: 'hooks',
        component:hooks
    }
]

export default new Router({
    mode: 'history',
    routes
})

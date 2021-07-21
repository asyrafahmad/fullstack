import Vue from 'vue'
import Router from 'vue-router'


Vue.use(Router)


import firstPage from './components/pages/myFirstVuePage'
import newRoutePage from './components/pages/newRoutePage'
import hooks from './components/pages/basic/hooks.vue'
import methods from './components/pages/basic/methods.vue'

/// admin project pages.
import home from './components/pages/home'
import tags from './admin/pages/tags'
import category from './admin/pages/category'
import useComp from './vuex/useComp'

const routes = [
    /// project routes pages.
    {
        path: '/testUseComp',
        name: 'useComp',
        component: useComp,
    },
    {
        path: '/',
        name: 'home',
        component: home,
    },
    {
        path: '/tags',
        name: 'tags',
        component: tags,
    },
    {
        path: '/category',
        name: 'category',
        component: category,
    },







    /// basic tutorials routes.
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
    },

    //more basic
    {
        path: '/methods',
        name: 'methods',
        component:methods
    }
]

export default new Router({
    mode: 'history',
    routes
})

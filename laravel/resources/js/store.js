import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        counter: 1000
    },
    getters: {
        getCOunter(state) {
            return state.counter
        }
    },

    mutations: {
        changeTheCounter(state, data) {
            state.counter += data;
        }
    },

    actions: {
        changeCounterAction({commit}, data) {
            commit('changeTheCounter', data)
        }
    }

})

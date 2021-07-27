import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        counter: 1000,
        //delete function
        deleteModalObj: {
            showDeleteModal: false,
            deleteUrl: '',
            data: null,
            deletingIndex: -1,
            isDeleted: false
        },
        //delete function
        user: false,
    },
    getters: {
        getCounter(state) {
            return state.counter
        },

        //delete function
        getDeleteModalObj(state) {
            return state.deleteModalObj
        }
        //delete function

    },

    mutations: {
        changeTheCounter(state, data) {
            state.counter += data;
        },

        //delete function
        setDeleteModal(state, data) {

            const deleteModalObj = {
                showDeleteModal: data.showDeleteModal,
                deleteUrl: data.deleteUrl,
                data : data.data,
                deletingIndex: data.deletingIndex,
                isDeleted: data
            }
            state.deleteModalObj = deleteModalObj
        },
        setDeletingModalObj(state, data) {
            state.deleteModalObj = data;
        },
        //delete function

        updateUser(state, data) {
            state.user = data;
        }
    },

    actions: {
        changeCounterAction({commit}, data) {
            commit('changeTheCounter', data)
        }
    }

})

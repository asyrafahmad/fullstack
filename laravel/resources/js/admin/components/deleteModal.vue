<template>
    <div>
        <!-- delete alert modal -->
        <Modal :value="getDeleteModalObj.showDeleteModal" :mask-closable="false" :closeable="false" width="360" >
            <p slot="header" style="color:#f60;text-align:center">
                <Icon type="ios-information-circle"></Icon>
                <span>Delete confirmation</span>
            </p>
            <div>
                <p>Are you sure want to delete tag?</p>
            </div>
            <div slot="footer">
                <Button type="default" size="large" @click="closeModal">Close</Button>
                <Button type="error" size="large" :loading="isDeleting" :disabled="isDeleting" @click="deleteTag">Delete</Button>
            </div>
        </Modal>
    </div>
</template>

<script>

import {mapGetters} from 'vuex'

export default {

    data(){
        return{
            isDeleting: false,
        }
    },
    methods: {
        async deleteTag(){

            this.isDeleting = true
            const res = await this.callApi('post', this.getDeleteModalObj.deleteUrl, this.getDeleteModalObj.data)
            if(res.status === 200){
                this.success('Tag has been deleted succesfully')
                this.$store.commit('setDeleteModal', true)
            }
            else{
                this.swr();
                this.$store.commit('setDeleteModal', false)
            }
            // this.isDeleting = false
        },
        closeModal(){
            this.$store.commit('setDeleteModal', false)
        }
    },
    computed: {
        ...mapGetters(['getDeleteModalObj'])
    },
}
</script>


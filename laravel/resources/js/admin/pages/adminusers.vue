<template>
    <div>
        <div class="content">
			<div class="container-fluid">

				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Tags <Button @click="addModal=true"><Icon type="md-add" />Add Admin</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
								<th>Full Name</th>
								<th>Email</th>
								<th>Type</th>
								<th>Created At</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(user,i) in users" :key="i" v-if="users.length">
								<td>{{user.id}}</td>
								<td class="_table_name">{{user.fullName}}</td>
								<td class="">{{user.email}}</td>
								<td class="">{{user.userType}}</td>
								<td>{{user.created_at}}</td>
								<td>
									<Button type="info" size="small" @click="showEditModal(user, i)">Edit</Button>
									<Button type="error" size="small" @click="showDeletingModal(user, i)" :loading="user.isDeleting">Delete</Button>
								</td>
							</tr>
								<!-- ITEMS -->

						</table>
					</div>
				</div>

                <!-- tag add modal -->
                <Modal v-model="addModal" title="Add User" :mask-closable="false" :closeable="false" >
                    <div class="space">
                        <Input type="text" v-model="data.fullName" placeholder="Fullname"   />
                    </div>
                    <div class="space">
                        <Input type="email" v-model="data.email" placeholder="Email" />
                    </div>
                    <div class="space">
                        <Input type="password" v-model="data.password" placeholder="Password" />
                    </div>
                    <div class="space">
                        <Select v-model="data.userType" placeholder="Select Admin Type">
                            <Option value="Admin">Admin</Option>
                            <Option value="Editor">Editor</Option>
                        </Select>
                    </div>


                    <div slot="footer">
                        <Button type="default" @click="addModal=false">Close</Button>
                        <Button type="primary" @click="addAdmin" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...' : 'Add User'}}</Button>
                    </div>
                </Modal>

                <!-- tag edit modal -->
                <Modal v-model="editModal" title="Edit User" :mask-closable="false" :closeable="false" >
                     <div class="space">
                        <Input type="text" v-model="editData.fullName" placeholder="Fullname"   />
                    </div>
                    <div class="space">
                        <Input type="email" v-model="editData.email" placeholder="Email" />
                    </div>
                    <div class="space">
                        <Input type="password" v-model="editData.password" placeholder="Password" />
                    </div>
                    <div class="space">
                        <Select v-model="editData.userType" placeholder="Select Admin Type">
                            <Option value="Admin">Admin</Option>
                            <Option value="Editor">Editor</Option>
                        </Select>
                    </div>

                    <div slot="footer">
                        <Button type="default" @click="editModal=false">Close</Button>
                        <Button type="primary" @click="editAdmin" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing...' : 'Edit User'}}</Button>
                    </div>
                </Modal>

                <deleteModal></deleteModal>
			</div>
		</div>
    </div>
</template>


<script>
import deleteModal from '../components/deleteModal.vue'
import {mapGetters} from 'vuex'

export default {

    data(){
        return {
            data: {
                fullName: '',
                email: '',
                password: '',
                userType: 'Admin',
            },
            addModal: false,
            editModal: false,
            isAdding: false,
            users: [],
            editData:{
                fullName: '',
                email: '',
                password: '',
                userType: 'Admin',
            },
            index: -1,
            showDeleteModal: false,
            isDeleting: false,
            deleteItem: {},
            deletingIndex: -1
        }
    },

    methods:  {
        async addAdmin(){

            if(this.data.fullName.trim()==''){
                return this.error('Full name is required')
            }

            if(this.data.email.trim()==''){
                return this.error('Email is required')
            }

            if(this.data.password.trim()==''){
                return this.error('Password is required')
            }

            if(this.data.userType.trim()==''){
                return this.error('User type is required')
            }

            const res = await this.callApi('post','app/create_users', this.data)

            if(res.status === 200 || res.status === 201){
                this.users.unshift(res.data)                          // array unshift
                this.success('Admin user has been added successfully')
                this.addModal = false
            }
            else{
                if(res.status == 422){
                    for(let i in res.data.errors){
                        this.error(res.data.errors[i][0])
                    }
                }
                else{
                    this.swr()
                }
            }
        },
        async editAdmin(){

            if(this.editData.fullName.trim()==''){                  // fullname validation
                return this.error('Full name is required')
            }
            if(this.editData.email.trim()==''){                     // email validation
                return this.error('Email is required')
            }
            if(this.editData.userType.trim()==''){                  // user type validation
                return this.error('User type is required')
            }

            const res = await this.callApi('post','app/edit_user', this.editData);

            if(res.status === 200){
                this.users[this.index] = this.editData
                this.success('User has been edited successfully');
                this.editModal = false;
            }
            else{
                if(res.status == 422){
                    for(let i in res.data.errors){
                        this.error(res.data.errors[i][0])
                    }
                }
                else{
                    this.swr();
                }
            }
        },

        showEditModal(user, index){
            let obj = {
                id : user.id,
                fullName : user.fullName,
                email : user.email,
                password : user.password,
            }

            this.editData = obj;
            this.editModal = true;
            this.index = index;
        },

        async deleteTag(){

            this.isDeleting = true
            // this.$set(tag, 'isDeleting', true);                                 // buffering before deleting

            const res = await this.callApi('post', 'app/delete_tag', this.deleteItem)
            if(res.status === 200){
                this.tags.splice(this.deletingIndex,1)
                this.success('Tag has been deleted succesfully')
            }
            else{
                this.swr();
            }

            this.isDeleting = false
            this.showDeleteModal = true
        },

        showDeletingModal(tag, index){

            const deleteModalObj = {
                showDeleteModal: true,
                deleteUrl: 'app/delete_tag',
                data : tag,
                deletingIndex: index,
                isDeleted: false
            }
            this.$store.commit('setDeletingModalObj', deleteModalObj)
            console.log('delete modal obj')

            // this.deleteItem = tag
            // this.deletingIndex = index
            // this.showDeleteModal = true
        }
    },

    async created(){

        const res = await this.callApi('get','app/get_users')

        if(res.status === 200){
            this.users = res.data
        }
        else{
            this.swr();
        }
    },

    components: {
        deleteModal
    },

    computed:{
        ...mapGetters(['getDeleteModalObj'])
    },
    watch: {
        getDeleteModalObj(obj){
            console.log(obj)

            if(obj.isDeleted){
                this.tags.splice(obj.deletingIndex, 1)
            }
        }
    }
}

</script>

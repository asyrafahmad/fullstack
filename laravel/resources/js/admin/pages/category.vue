<template>
    <div>
        <div class="content">
			<div class="container-fluid">

				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Category <Button @click="addModal=true"><Icon type="md-add" />Add Category</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
								<th>Tag Name</th>
								<th>Created At</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->

								<!-- ITEMS -->
							<!-- <tr v-for="(tag,i) in tags" :key="i" v-if="tags.length"> -->
							<tr v-for="(tag,i) in tags" :key="i" >
								<td>{{tag.id}}</td>
								<td class="_table_name">{{tag.tagName}}</td>
								<td>{{tag.created_at}}</td>
								<td>
									<Button type="info" size="small" @click="showEditModal(tag, i)">Edit</Button>
									<Button type="error" size="small" @click="showDeletingModal(tag, i)" :loading="tag.isDeleting">Delete</Button>
								</td>
							</tr>
							    <!-- ITEMS -->
						</table>
					</div>
				</div>

                <!-- tag add modal -->
                <Modal v-model="addModal" title="Add tag" :mask-closable="false" :closeable="false" >
                    <Input v-model="data.tagName" placeholder="Add category name" />
                    <div class="space"></div>
                    <Upload
                        multiple
                        type="drag"
                        :headers="{'x-csrf-token' : token, 'X-Requested-With' : 'XMLHttpRequest'}"
                        :on-success="handleSuccess"
                        :on-error="handleError"
                        :format="['jpg','jpeg','png']"
                        :max-size="2048"
                        :on-format-error="handleFormatError"
                        :on-exceeded-size="handleMaxSize"
                        action="/app/upload">
                        <div style="padding: 20px 0">
                            <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                            <p>Click or drag files here to upload</p>
                        </div>
                    </Upload>
                    <div class="image_thumb" v-if="data.iconImage">
                        <img :src="`/uploads/${data.iconImage}`" />
                    </div>
                    <div slot="footer">
                        <Button type="default" @click="addModal=false">Close</Button>
                        <Button type="primary" @click="addTag" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...' : 'Add Tag'}}</Button>
                    </div>
                </Modal>

                <!-- tag edit modal -->
                <Modal v-model="editModal" title="Edit tag" :mask-closable="false" :closeable="false" >
                    <input v-model="editData.tagName" placeholder="Edit tag name" style="width: 300px" />

                    <div slot="footer">
                        <Button type="default" @click="editModal=false">Close</Button>
                        <Button type="primary" @click="editTag" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing...' : 'Edit Tag'}}</Button>
                    </div>
                </Modal>

                 <!-- delete alert modal -->
                <Modal v-model="showDeleteModal" width="360" >
                    <p slot="header" style="color:#f60;text-align:center">
                        <Icon type="ios-information-circle"></Icon>
                        <span>Delete confirmation</span>
                    </p>
                    <div>
                        <p>Are you sure want to delete tag?</p>
                    </div>
                    <div slot="footer">
                        <Button type="error" size="large" long :loading="isDeleting" :disabled="isDeleting" @click="deleteTag">Delete</Button>
                    </div>
                </Modal>

			</div>
		</div>
    </div>
</template>


<script>
export default {

    data(){
        return {
            data: {
                iconImage: '',
                categoryName: ''
            },
            addModal: false,
            editModal: false,
            isAdding: false,
            tags: [],
            editData:{
                tagName: '',
            },
            index: -1,
            showDeleteModal: false,
            isDeleting: false,
            deleteItem: {},
            deletingIndex: -1,
            token: ''
        }
    },

    methods:  {
        async addTag(){

            if(this.data.tagName.trim()==''){
                return this.error('Tag name is required')
            }

            const res = await this.callApi('post','app/create_tag', this.data)

            if(res.status === 200){
                this.tags.unshift(res.data)                          // array unshift
                this.success('Tag has been added successfully')
                this.addModal = false
            }
            else{
                if(res.status == 422){
                    console.log(res.data.errors.tagName);

                    if(res.data.errors.tagName){
                        this.error(res.data.errors.tagName[0])
                    }
                }
                else{
                    this.swr()
                }
            }
        },
        async editTag(){

            if(this.editData.tagName.trim()==''){
                return this.error('Tag name is required');
            }

            const res = await this.callApi('post','app/edit_tag', this.editData);

            if(res.status === 200){
                this.tags[this.index].tagName = this.editData.tagName;
                this.success('Tag has been edited successfully');
                this.editModal = false;
            }
            else{
                if(res.status == 422){
                    console.log(res.data.errors.tagName);

                    if(res.data.errors.tagName){
                        this.error(res.data.errors.tagName[0]);
                    }
                }
                else{
                    this.swr();
                }
            }
        },

        showEditModal(tag, index){
            let obj = {
                id : tag.id,
                tagName : tag.tagName
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
            this.deleteItem = tag
            this.deletingIndex = index
            this.showDeleteModal = true
        },

        handleSuccess (res, file) {
           this.data.iconImage = res;
        },
        handleError (res, file) {
           console.log('res', res)
           console.log('file', file)
           this.$Notice.warning({
               title: 'The file format is incorrect',
               desc: `${file.errors.file.length ? file.errors.file[0] : 'Something went wrong!' }`
           })
        },
        handleFormatError (file) {
            this.$Notice.warning({
                title: 'The file format is incorrect',
                desc: 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
            });
        },
        handleMaxSize (file) {
            this.$Notice.warning({
                title: 'Exceeding file size limit',
                desc: 'File  ' + file.name + ' is too large, no more than 2M.'
            });
        },
    },

    async created(){

        this.token = window.Laravel.csrfToken;
        const res = await this.callApi('get','app/get_tags')

        if(res.status === 200){
            this.tags = res.data
        }
        else{
            this.swr();
        }

        // const res = await this.callApi('post', '/app/create_tag', {tagName: 'testtag'});

        // if(res.status==200){
        //     console.log(res)
        // }
        // else{
        //     console.log(res);
        //     console.log('running')
        // }
    }
}

</script>

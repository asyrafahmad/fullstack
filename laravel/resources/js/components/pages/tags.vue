<template>
    <div>
        <div class="content">
			<div class="container-fluid">

				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Tags <Button @click="addModal=true"><Icon type="md-add" /></Button></p>

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
									<Button type="info" size="small">Edit</Button>
									<Button type="error" size="small">Delete</Button>
								</td>
							</tr>
								<!-- ITEMS -->

						</table>
					</div>
				</div>

                <Modal v-model="addModal" title="Add tag" :mask-closable="false" :closeable="false" >
                    <input v-model="data.tagName" placeholder="Add tag name" style="width: 300px" />

                    <div slot="footer">
                        <Button type="default" @click="addModal=false">Close</Button>
                        <Button type="primary" @click="addTag" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...' : 'Add Tag'}}</Button>
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
            data : {
                tagName: ''
            },
            addModal: false,
            isAdding: false,
            tags: []
        }
    },

    methods:  {
        async addTag(){

            if(this.data.tagName.trim()==''){
                return this.e('Tag name is required')
            }

            const res = await this.callApi('post','app/create_tag', this.data)

            if(res.status === 200){
                this.tags.unshift(res.data)
                this.success('Tag has been added successfully')
                this.addModal = false
            }
            else{
                this.swr()
            }
        }
    },

    async created(){

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

<template>
    <div>
        <h1>The number is :{{views}}</h1>
        <button @click="updateCounter(1)">Increase by 1</button>
        <button @click="updateCounter(-1)">Decrease by 1</button>

        <br>
        <br><br>

        <div v-for="(blog, i) in blogs" :key="i">
            <h1>{{ blog.title }}</h1>
            <p>{{ blog.post }}</p>
        </div>
    </div>
</template>


<script>

export default{
    data(){
        return {
           views: 0,
           blogs: []
        }
    },

    methods: {
        updateCounter(number){
            this.views += number
        }
    },

    created(){
        // call the server to get views of this vlog post...
        this.views = 100

        //get the blog posts
        let posts = [
               {title: ' this is blog title', 'post': 'this is the blog post 1', id: 1},
               {title: ' this is blog title', 'post': 'this is the blog post 2', id: 2},
               {title: ' this is blog title', 'post': 'this is the blog post 3', id: 3},
               {title: ' this is blog title', 'post': 'this is the blog post 4', id: 4}
        ]

        this.blogs = posts
    }

}

</script>

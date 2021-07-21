<template>
    <div>
        <div class="content">
			<div class="container-fluid">
                <h1>i will show how all others components react to changes</h1>
                <h2>The master component :  {{$store.state.counter}}</h2>
            </div>
            <div>
                <compA></compA>
            </div>
            <div>
                <compB></compB>
            </div>
            <div>
                <compC></compC>
            </div>
            <Button type="info" @click="changeCounter">Change the state of the counter</Button>
        </div>
    </div>
</template>

<script>

import compA from './compA';
import compB from './compB';
import compC from './compC';

export default {

    data(){
        return {}
    },
    methods: {
        changeCounter(){
            this.$store.commit('changeTheCounter', 1)
        }
    },
    created(){
        console.log(this.$store.state.counter);
    },
    components: {
        compA,
        compB,
        compC,
    }
}
</script>

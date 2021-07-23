<template>
    <div>
        <div class="content">
			<div class="container-fluid">
                <h1>I will show how all others components react to changes</h1>
                <h2>The master component :  {{counter}}</h2>
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
import {mapGetters, mapActions} from 'vuex'

export default {

    data(){
        return {
            localVar: 'some value',
        }
    },
    methods: {
        ...mapActions([
            'changeCounterAction'
        ])
    },
    computed : {
        ...mapGetters({
            'counter' : 'getCounter'
        })
    },
    methods: {
        changeCounter(){
            this.$store.dispatch('changeCounterAction',1)
            // this.$store.commit('changeTheCounter', 1)
        },
        runSomethingWhenCounterChange(){
            console.log('I am running based on the changes happening.')
        }
    },
    created(){
        console.log(this.$store.state.counter);
    },
    components: {
        compA,
        compB,
        compC,
    },
    watch:{
        counter(value){
            console.log('counter is changing', value)
            this.runSomethingWhenCounterChange();
            console.log('local var', localVar);
        }
    }
}
</script>

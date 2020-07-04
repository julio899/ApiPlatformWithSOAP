<template>
    <div id="app">
        <loader v-if="loading" :datos="$data" />
        <component v-if="!loading" :datos="$data" :is="getPage()" v-on:setearLoading="setLoad($event)"></component>
    </div>
</template>

<script>
/* Other away for emit in parent register -> @setPage="this.setPage($event)" 
    In Child :
     example -> this.$emit("setearLoading", true);
*/
import loader from './components/loader.vue'
import login from './components/login.vue'
import store from './components/store.vue'

export default {
    name: 'App',
    components: {
        loader,
        login,
        store,
    },
    data: function() {
        return {
            loading: true,
            pages: ['login', 'store'],
            pageSelected: 'login',
        }
    },
    methods: {
        setLoad: function(loadStatus) {
            this.loading = loadStatus
            console.log('loading :', this.loading)
        },
        setPage: function(page) {
            this.pageSelected = page
            console.log('setPage :', this.pageSelected)
        },
        getPage: function() {
            return this.pageSelected
        },
    },
}
</script>

<style>
* {
    margin: 0;
    padding: 0;
    border: 0;
}
</style>

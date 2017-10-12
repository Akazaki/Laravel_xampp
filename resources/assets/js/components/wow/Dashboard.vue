<template>
	<div>
		<navbar></navbar>
		<div v-if="userState.authenticated">
		Welcome
		</div>
		<div v-else>
		Please <a href="/wow/login">Login</a>
		</div>
	</div>
</template>

<script>
import http from '../../services/http'
import VueRouter from 'vue-router'
Vue.use(VueRouter)
Vue.component('navbar', require('../../components/Layouts/Navbar.vue'))

    export default {
		data (){
			return {
			}
		},
		created () {
		},
	}
</script>
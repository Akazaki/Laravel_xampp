<template>
	<div>
		<navbar></navbar>
		<div v-if="loginStatus">
			Welcome
		</div>
	</div>
</template>

<script>
// import http from '../../services/http'
import VueRouter from 'vue-router'
Vue.use(VueRouter)
Vue.component('navbar', require('../../components/Layouts/Navbar.vue'))

    export default {
		data (){
			return {
				loginStatus: false,
			}
		},
		created () {
			this.$store.dispatch('GET_USER').then(res => {
				this.loginStatus = true
			}, error => {
				this.$router.push('/wow/login')
			})
		},
	}
</script>
<template>
	<div>
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="Navbar">
			<ul class="nav navbar-nav navbar-left">
				<li>
					<div class="header_logo">
						<router-link to="/wow"><img src="/public/wow/common/img/logo_wow.png" alt="Contents Management Flamework WOW"></router-link>
					</div>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li>{{ user }}</li>
				<li><router-link to="/about">About</router-link></li>
				<li><a href="javascript:void(0);" v-on:click="logout()">Log out</a></li>
			</ul>
		</div>
	</div>
</template>

<script>
// import http from '../../services/http'
// import VueRouter from 'vue-router'
// Vue.use(VueRouter)

export default {
	data (){
		return {
			user: ''
		}
	},
	//props: ['user'],
	created () {
		this.$store.dispatch('GET_USER').then(res => {
			this.user = res.data.user.label_text
		}, error => {
			this.$router.push('/wow/login')
		})
	},
	methods: {
		logout(){
			this.$store.dispatch('LOGOUT')
			this.$router.push('/wow/login')
		}
	}
}
</script>
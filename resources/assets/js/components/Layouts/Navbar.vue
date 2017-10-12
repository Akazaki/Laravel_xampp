<template>
	<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="collapse navbar-collapse" id="Navbar">
		<ul class="nav navbar-nav navbar-right">
			<li><router-link to="/about">About</router-link></li>

			<!-- ここから追加 -->
			<li class="dropdown" v-if="userState.authenticated">
				<a href="#" class="dropdown-toggle"
					 data-toggle="dropdown"
					 role="button" aria-haspopup="true" aria-expanded="false">
					 {{ userState.user.name }}
					 <span class="caret"></span>
				</a>
				<ul class="dropdown-menu">
					<li><a @click="logout()">Log out</a></li>
				</ul>
			</li>
			<li v-else>
				<router-link to="/wow/login">Log in</router-link>
			</li>
		</ul>
	</div>
</template>

<script>
import userStore from '../../stores/userStore'

export default {
	data (){
		return {
			userState: userStore.state
		}
	},
	methods: {
		logout() {
			userStore.logout( () => {
				this.$router.push('/wow/login')
			})
		}
	}
}
</script>
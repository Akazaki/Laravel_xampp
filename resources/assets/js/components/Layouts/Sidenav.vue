<template>
	<div id="Sidebar" class="col-xs-3 col-xs-2 sidebar">
		<div class='sidebar'>
			<ul class='nav'>
				<li data-toggle="collapse" href="#collapse-A">
					<a class='active' href="#"><span class="caret"></span> 投稿</a>
				</li>
				<ul id="collapse-A" class="collapse">
					<li><a href="A-1">A-1</a></li>
					<li><a href="A-2">A-2</a></li>
					<li><a href="A-3">A-3</a></li>
				</ul>
				<li>
					<a>画像</a>
				</li>
			</ul>
		</div>
	</div>
</template>

<script>
// import userStore from '../../stores/userStore'

export default {
	// data (){
	// 	// return {
	// 	// 	userState: this.$store.
	// 	// }
	// },
	methods: {
		logout(){
			this.$store.dispatch('LOGOUT')
			this.$router.push('/wow/logout')
		}
	}
}
</script>
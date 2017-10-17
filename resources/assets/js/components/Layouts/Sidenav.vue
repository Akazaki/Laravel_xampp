<template>
	<div id="Sidebar" class="col-xs-3 col-xs-2 sidebar">
		<div class='sidebar'>
			<ul class='nav'>
				<li data-toggle="collapse" href="#collapse-A">
					<a class='active' href="#"><span class="caret"></span> menu A</a>
				</li>
				<ul id="collapse-A">
					<li><a href="A-1">A-1</a></li><!-- 閉じタグ省略可能 -->
					<li><a href="A-2">A-2</a></li><!-- 閉じタグ省略可能 -->
					<li><a href="A-3">A-3</a></li><!-- 閉じタグ省略可能 -->
				</ul>
				<li>
					<a>Statistics</a>
				</li>
				<li>
					<a>Milestones</a>
				</li>
				<li>
					<a>Experiments</a>
				</li>
				<li>
					<a>Previews</a>
				</li>
				<li>
					<a>Assets</a>
				</li>
				<li>
					<a>Settings</a>
				</li>
				<li>
					<a>Logout</a>
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
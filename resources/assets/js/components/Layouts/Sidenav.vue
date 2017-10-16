<template>
	<div id="Sidebar" class="col-xs-3 col-xs-2 sidebar">
		<ul class="nav nav-sidebar sidebar-nav">
			<li class="sidebar-brand" data-toggle="collapse" href="#collapse-A">
				<a href="#"><span class="caret"></span> menu A</a>
			</li><!-- collapse を正常に動作させるためには、閉じタグが必要。閉じないと、下記のリンクをクリックしたときに、collapse が発火する -->
			<ul id="collapse-A" class="collapse">
				<li><a href="A-1">A-1</a></li><!-- 閉じタグ省略可能 -->
				<li><a href="A-2">A-2</a></li><!-- 閉じタグ省略可能 -->
				<li><a href="A-3">A-3</a></li><!-- 閉じタグ省略可能 -->
			</ul>
			<li  class="sidebar-brand" data-toggle="collapse" href="#collapse-B"><a href="#"><span class="caret"></span> menu B</a></li><!-- collapse を動作させるために閉じタグが必要 -->
			<ul id="collapse-B" class="collapse">
				<li><a href="B-1">B-1</a></li><!-- 閉じタグ省略可能 -->
				<li><a href="B-2">B-2</a></li><!-- 閉じタグ省略可能 -->
				<li><a href="B-3">B-3</a></li><!-- 閉じタグ省略可能 -->
			</ul>
		</ul>
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
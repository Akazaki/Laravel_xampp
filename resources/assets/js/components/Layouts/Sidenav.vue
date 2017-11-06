<template>
	<div id="Sidebar" class="col-xs-3 col-xs-2 sidebar">
		<aside class="sidebar">
			<div id="leftside-navigation" class="nano">
				<ul class="nano-content nav">
					<li>
						<router-link to="/wow/"><i class="fa fa-dashboard"></i><span>記事一覧</span></router-link>
					</li>
					<li class="sub-menu active" data-toggle="collapse" href="#collapse-A">
						<a href="javascript:void(0);"><i class="fa fa-envelope"></i><span>記事一覧</span><i class="arrow fa fa-angle-right pull-right"></i></a>
						<ul id="collapse-A" class="collapse">
							<li class="active">
								<a href="mail-inbox.html">Logout</a>
							</li>
							<li>
								<a href="mail-compose.html">test</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</aside>
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
	}
}
</script>
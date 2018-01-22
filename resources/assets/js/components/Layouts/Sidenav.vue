<template>
	<div id="Sidebar" class="col-xs-3 col-xs-2 sidebar">
		<aside class="sidebar">
			<div id="leftside-navigation" class="nano">
				<div id="Auther">
					<div class="autherImg">
						<img src="/public/wow/common/img/person03.jpg">
					</div>
					<p class="autherName">
						{{ autherName }}
					</p>
				</div>
				<ul class="nano-content nav">
					<template v-for="(value, key) in menu">
						<li>
							<router-link v-bind:to="'/wow/list/' + value.label_text"><i class="fa fa-dashboard"></i><span>{{ value.menuname_text }}</span></router-link>
						</li>
						<!-- <li>
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
						</li> -->
					</template>
				</ul>
			</div>
		</aside>
	</div>
</template>

<script>
// import userStore from '../../stores/userStore'

export default {
	data (){
		return {
			autherName: '',
			menu: {},
		}
	},
	created(){
		this.autherName = this.$store.getters.user.label_text;
		this.get_menu();
	},
	methods: {
		 /**
		 * メニューデータ取得
		 */
		get_menu: function(){
			this.menu = this.$store.getters.menu;

			//メニューデータ無ければ取得
			if(!this.menu){
				this.$store.dispatch('SET_MENU').then(res => {
					this.menu = this.$store.getters.menu;
				}, error => {
					//error
				})
			};
		}
		// logout(){
		// 	this.$store.dispatch('LOGOUT').then(res => {
		// 		this.$router.push('/wow/login')
		// 	}, error => {
		// 	})
		// }
	}
}
</script>
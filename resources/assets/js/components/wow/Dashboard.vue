<template>
	<div>
		<div id="Wrapper">
			<navbar></navbar>
			<sidenav></sidenav>

			<div id="Main">
				<div id="Postlist">
					<ul class="button_box">
						<li class="left">
							<p id="Post_title">投稿</p>
						</li>
						<li class="left">
							<div class="button_green">
								<router-link to="/">
									新規追加
								</router-link>
							</div>
						</li>
						<li class="right">
							<div class="search_button">
								<form>
									<input type="search" placeholder="検索">
								</form>
							</div>
						</li>
					</ul>

					<div id="table-content">
						<table cellspacing="0" cellpadding="0">
							<thead>
								<tr>
									<td><input type="checkbox"></td>
									<template v-for="column in list_columns">
										<td>{{column}}</td>
									</template>
								</tr>
							</thead>
							<tbody>
								<tr v-for="post in posts">
									<td class="check-td"><input type="checkbox"></td>
									<td class="id-td">{{post.id}}</td>
									<td class="name-td">
										<router-link v-bind:to="{ name : 'Posts', params : { id: post.id }}">{{post.label_text}}</router-link>
									</td>
									<td class="date-td">{{post.created_at}}</td>
									<td class="acknowledge-td">{{post.acknowledge}}</td>
								</tr>
							</tbody>
						</table>
					</div>
					
					<!--ページャー(子からのイベント実行)-->
					<pager　@getposts="acceptance_posts"></pager>
					
				</div>
			</div>
			
		</div>
		<footerber></footerber>
	</div>
</template>

<script>
import wow from '../../services/wow'
import VueRouter from 'vue-router'
Vue.use(VueRouter)
Vue.component('navbar', require('../../components/Layouts/Navbar.vue'))
Vue.component('sidenav', require('../../components/Layouts/Sidenav.vue'))
Vue.component('footerber', require('../../components/Layouts/Footer.vue'))
Vue.component('pager', require('../../components/Layouts/Pager.vue'))

	export default {
		data (){
			return {
				posts: {},//記事データ
				list_columns: '',//カラムリスト
			}
		},
		created () {
		},
		methods: {
			//ページャーコンポーネントから実行されるイベント
		    acceptance_posts　: function () {
				this.posts = this.$store.getters.posts.posts.data;
				this.list_columns = this.$store.getters.posts._listColumns;
			}
		},
	}
</script>
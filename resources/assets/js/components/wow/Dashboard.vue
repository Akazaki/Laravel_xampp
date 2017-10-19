<template>
	<div id="Wrapper">
		<navbar></navbar>
		<sidenav></sidenav>
		<div>
			<div id="Postlist">
				<!-- <ol id="Breadcrumb" class="breadcrumb v1">
					<li class="breadcrumb-level"><a href="">Level 1</a></li>
					<li class="breadcrumb-level"><a href="">Level 2</a></li>
					<li class="breadcrumb-level"><a>Level 3</a></li>
				</ol> -->
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
				<div id="demo1">
					<ul>
					<li v-for="post in posts">{{post.label_text}}</li>
					</ul>
				</div>
				<div id="table-content">
					<table cellspacing="0" cellpadding="0">
					<thead>
						<tr>
						<td><input type="checkbox"></td>
						<td>ID</td>
						<td>タイトル</td>
						<td>公開日</td>
						<td>ステータス</td>
						<td></td>
						</tr>	
					</thead>
					<tbody>
						<tr>
						<td><input type="checkbox"></td>
						<td>001</td>
						<td class="name-td">
							<router-link to="/">テスト投稿テスト投稿テスト投稿</router-link>
						</td>
						<td class="desc-td">2017-08-31 20:30:50</td>
						<td class="date-td">公開</td>
						<td></td>
						</tr>
						<tr>
						<td><input type="checkbox"></td>
						<td>001</td>
						<td class="name-td">
							<router-link to="/">テスト投稿テスト投稿テスト投稿</router-link>
						</td>
						<td class="desc-td">2017-08-31 20:30:50</td>
						<td class="date-td">公開</td>
						<td></td>
						</tr>
						<tr>
						<td><input type="checkbox"></td>
						<td>001</td>
						<td class="name-td">
							<router-link to="/">テスト投稿テスト投稿テスト投稿</router-link>
						</td>
						<td class="desc-td">2017-08-31 20:30:50</td>
						<td class="date-td">公開</td>
						<td></td>
						</tr>
						<tr>
						<td><input type="checkbox"></td>
						<td>001</td>
						<td class="name-td">
							<router-link to="/">テスト投稿テスト投稿テスト投稿</router-link>
						</td>
						<td class="desc-td">2017-08-31 20:30:50</td>
						<td class="date-td">公開</td>
						<td></td>
						</tr>
						<tr>
						<td><input type="checkbox"></td>
						<td>001</td>
						<td class="name-td">
							<router-link to="/">テスト投稿テスト投稿テスト投稿</router-link>
						</td>
						<td class="desc-td">2017-08-31 20:30:50</td>
						<td class="date-td">公開</td>
						<td></td>
						</tr>
						<tr>
						<td><input type="checkbox"></td>
						<td>001</td>
						<td class="name-td">
							<router-link to="/">テスト投稿テスト投稿テスト投稿</router-link>
						</td>
						<td class="desc-td">2017-08-31 20:30:50</td>
						<td class="date-td">公開</td>
						<td></td>
						</tr>
						<tr>
						<td><input type="checkbox"></td>
						<td>001</td>
						<td class="name-td">
							<router-link to="/">テスト投稿テスト投稿テスト投稿</router-link>
						</td>
						<td class="desc-td">2017-08-31 20:30:50</td>
						<td class="date-td">公開</td>
						<td></td>
						</tr>
					</tbody>
					</table>
				</div> 
			</div>			
		</div>			
	</div>
</template>

<script>
// import http from '../../services/http'
import VueRouter from 'vue-router'
Vue.use(VueRouter)
Vue.component('navbar', require('../../components/Layouts/Navbar.vue'))
Vue.component('sidenav', require('../../components/Layouts/Sidenav.vue'))

	export default {
		data (){
			return {
				user: '',
				loginStatus: false,
				posts: {}
			}
		},
		created () {
			axios.post('/api/wow/postList', {})
			.then(res => {
				this.posts = res.data.data
				console.log(res)
			}).catch(error => {
				console.log(error);
			});
		},
	}
</script>
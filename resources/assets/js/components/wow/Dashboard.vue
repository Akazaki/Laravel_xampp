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
							<td><input type="checkbox"></td>
							<td class="id-td">{{post.id}}</td>
							<td class="name-td">
								<router-link to="/">{{post.label_text}}</router-link>
							</td>
							<td class="date-td">{{post.created_at}}</td>
							<td class="acknowledge-td">{{post.acknowledge}}</td>
						</tr>
					</tbody>
					</table>
				</div>
				<div id="Pagination">
					<ul class="pager-list">
						<li class="pager-item pager-item-last"><a href="javascript:void(0);" v-on:click="posts_get(1)" v-if="posts">&lt;&lt;</a></li>
						<li class="pager-item pager-item-first"><a href="javascript:void(0);" v-on:click="posts_get(current_page-1)" v-if="isStartPage">&lt;</a></li>

						<template v-for="num in page_length">
							<li class="pager-item pager-item-active" v-on:click="posts_get(num)">
								<template v-if="num !== current_page">
									<a href="javascript:void(0);">{{num}}</a>
								</template>
								<template v-else>
									<span>
										<a href="javascript:void(0);">{{num}}</a>
									</span>
								</template>
							</li>
						</template>

						<li class="pager-item pager-item-last"><a href="javascript:void(0);" v-on:click="posts_get(current_page+1)" v-if="isEndPage">&gt;</a></li>
						<li class="pager-item pager-item-last"><a href="javascript:void(0);" v-on:click="posts_get(last_page)" v-if="last_page">&gt;&gt;</a></li>
					</ul>
				</div>
				
			</div>
		</div>	
		<footer></footer>		
	</div>
</template>

<script>
import wow from '../../services/wow'
import VueRouter from 'vue-router'
Vue.use(VueRouter)
Vue.component('navbar', require('../../components/Layouts/Navbar.vue'))
Vue.component('sidenav', require('../../components/Layouts/Sidenav.vue'))

	export default {
		data (){
			return {
				posts: {},//記事データ
				current_page: 1,//現在のページ
				isStartPage: false,
				isEndPage: false,
				last_page: 0,//ラストのページ番号
				per_page: 0,//一度の取得数
				page_length: 0,//全ページ数
				list_columns: '',//カラムリスト
			}
		},
		created () {
			this.posts_get(this.current_page);
		},
		//props: ['user'],
		methods: {
			//ページング処理
			posts_get(page){
				axios.post('/api/wow/postList?page='+page, {})
				.then(res => {
					var postsdata = res.data.posts;

					this.list_columns = res.data._listColumns
					this.posts = postsdata.data
					this.current_page = postsdata.current_page
					this.last_page = postsdata.last_page
					this.page_length = Math.ceil(postsdata.total / postsdata.per_page);
					
					//前のページがあるか
					if(postsdata.prev_page_url){
						this.isStartPage = true
					}else{
						this.isStartPage = false
					}

					//次のページがあるか
					if(postsdata.next_page_url){
						this.isEndPage = true
					}else{
						this.isEndPage = false
					}
				}).catch(error => {
					console.log(error);
				});
			}
		},
		computed:{
			// pageCount: function() {
	  //           return this.page_length
	  //       }
		}
	}
</script>
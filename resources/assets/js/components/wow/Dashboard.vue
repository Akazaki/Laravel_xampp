<template>
	<div>
		<div id="Wrapper">
			<navbar></navbar>
			<sidenav></sidenav>

			<div id="Main">
				<div id="Postlist">
					<ul class="button_box">
						<li class="left">
							<p id="Post_title">一覧</p>
						</li>
						<li class="left">
							<div class="button_green">
								<router-link v-bind:to="{ path: '/wow/edit/'+dataName+'/0'}">
									新規追加
								</router-link>
							</div>
						</li>
						<li class="right">
							<div class="search_button">
								<input type="search" placeholder="検索" v-model="searchValue">
							</div>
						</li>
					</ul>

					<template v-if="show">
						<template v-if="dataName != 'admin'">
							<div id="DropDownEdit">
								<div class="dropdown hover">
									<a href="javascript:void(0);">一括編集</a>
									<ul>
										<li><a href="javascript:void(0);" v-on:click="doneMultiAction('delete')">削除</a></li>
										<li><a href="javascript:void(0);" v-on:click="doneMultiAction('publish')">公開</a></li>
										<li><a href="javascript:void(0);" v-on:click="doneMultiAction('private')">非公開</a></li>
									</ul>
								</div>
							</div>
						</template>
						<div id="table-content">
							<table cellspacing="0" cellpadding="0">
								<thead>
									<tr>
										<td class="check-td-tr">
											<input type="checkbox" id="checkall" v-model="checkMulti"/>
											<label for="checkall"></label>
										</td>
										<template v-for="column in list_columns">
											<td>{{column}}</td>
										</template>
									</tr>
								</thead>
								<tbody>
									<tr v-for="post in posts">
										<td class="check-td-tr">
											<input type="checkbox" v-bind:id="'checkid' + post.id" :value="post.id" v-model="checkid"/>
											<label v-bind:for="'checkid' + post.id"></label>
										</td>
										<td class="id-td">{{post.id}}</td>
										<td class="name-td">
											<router-link v-bind:to="{ path: '/wow/edit/'+dataName+'/'+post.id}">{{post.label_text}}</router-link>
										</td>
										<td class="date-td">{{post.created_at}}</td>
										<td class="acknowledge-td">{{acknowledgeMaster[post.acknowledge_radio]}}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</template>
					<template v-else>
						<loadingsmall></loadingsmall>
					</template>
					<template v-show="show">
						<!--ページャー(子からのイベント実行)-->
						<pager v-bind:dataName="dataName" v-bind:searchValue="searchValue" v-bind:postReloadFlg="postReloadFlg" @getposts="acceptance_posts"></pager>
					</template>
					
				</div>
			</div>
			
		</div>
		<!-- <footerbar></footerbar> -->
	</div>
</template>

<script>
import wow from '../../services/wow'
import VueRouter from 'vue-router'
Vue.use(VueRouter)
Vue.component('navbar', require('../../components/Layouts/Navbar.vue'))
Vue.component('sidenav', require('../../components/Layouts/Sidenav.vue'))
Vue.component('footerbar', require('../../components/Layouts/Footer.vue'))
Vue.component('pager', require('../../components/Layouts/Pager.vue'))

	export default {
		props: ['dataName'],
		data (){
			return {
				posts: {},//記事データ
				list_columns: '',//カラムリスト
				show: false,
				checkMulti: false,
				checkid: [],
				postReloadFlg: false,
				acknowledgeMaster: {1:'公開', 2:'非公開', 3:'下書き'},
				searchValue: '',
			}
		},
		created () {
			if(this.dataName === 'post' || this.dataName === 'admin'){

			}else{
				this.$router.push('/wow/login');
				return false;
			}
		},
		watch: {
			//ページ遷移時
			dataName: function () {
				this.show = false;
				this.checkMulti = false;
				this.checkid = [];
				this.searchValue = '';
			},
			//一括チェック
			checkMulti: function(){
				if(this.checkMulti){
					var self = this;
					Object.keys(this.posts).forEach(function (key, i) {
						if(self.posts[key].id){
							self.checkid.unshift(self.posts[key].id);
						}
					});
				}else{
					this.checkid = [];
				}
			}
		},
		methods: {
			//ページャーコンポーネントから実行されるイベント
			acceptance_posts　: function () {
				this.postReloadFlg = false;
				this.checkid = [];
				this.checkMulti = false;
				this.show = true;
				this.posts = this.$store.getters.posts.posts.data;
				this.list_columns = this.$store.getters.posts._listColumns;
			},
			// 記事一括変更
			doneMultiAction: function (action) {
				this.searchValue = '';
				if(this.checkid.length > 0 && (action === 'delete' || action === 'publish' || action === 'private')){
					axios.post('/api/wow/'+this.dataName+'MultiAction', {id: this.checkid, action: action})
					.then(res => {
						if(res.data !== undefined && res.status == 200){
							this.postReloadFlg = true;
						}else{
							//this.$router.push('/wow/login')
						}
						
					}).catch(error => {
						if(error.response && error.response.data){
							if(error.response.data.error == 'token_not_provided' || error.response.data.error == 'token_expired'){
								//token切れ
								this.$router.push('/wow/login');
								return false;
							}
						}
						console.log(error);
					});
				}else{
					return false;
				}
			}
		},
	}
</script>
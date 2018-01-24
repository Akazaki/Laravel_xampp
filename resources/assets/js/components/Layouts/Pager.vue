<template>
	<div id="Pagination" v-if="show">
		<ul class="pager-list">
			<li v-if="1 !== current_page" class="pager-item pager-item-last"><a href="javascript:void(0);" v-on:click="get_posts(1, searchValue)" v-if="posts">&lt;&lt;</a></li>
			<li class="pager-item pager-item-first"><a href="javascript:void(0);" v-on:click="get_posts(current_page-1, searchValue)" v-if="isStartPage">&lt;</a></li>

			<template v-for="num in page_length">
				<li class="pager-item pager-item-active" v-on:click="get_posts(num, searchValue)">
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

			<li class="pager-item pager-item-last"><a href="javascript:void(0);" v-on:click="get_posts(current_page+1, searchValue)" v-if="isEndPage">&gt;</a></li>
			<li v-if="last_page !== current_page" class="pager-item pager-item-last"><a href="javascript:void(0);" v-on:click="get_posts(last_page, searchValue)" v-if="last_page">&gt;&gt;</a></li>
		</ul>
	</div>
</template>

<script>
// import userStore from '../../stores/userStore'

	export default {
		props: ['dataName', 'postReloadFlg', 'searchValue'],
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
				show: false,
			}
		},
		watch: {
			//ページ遷移時
			dataName: function () {
				this.show = false;
				this.current_page = 1;
				this.get_posts(this.current_page, this.searchValue);
			},
			//親で記事数変更処理があった場合、記事再読み込み
			postReloadFlg: function() {
				if(this.postReloadFlg === true){
					this.get_posts(this.current_page, this.searchValue);
				}
			},
			//検索
			searchValue: function(){
				this.get_posts(this.current_page, this.searchValue);
			}
		},
		created () {

			if(this.dataName === 'post' || this.dataName === 'admin'){
				
			}else{
				this.$router.push('/wow/login');
				return false;
			}

			this.get_posts(this.current_page, this.searchValue);
		},
		methods: {
			//ページング処理
			get_posts(page, searchValue){
				axios.post('/api/wow/'+this.dataName+'List', {page: page, searchValue: searchValue})
				.then(res => {
					if(res.data !== undefined && res.status == 200 && res.data.posts.data.length > 0){
						var data = res.data;
						var postsdata = data.posts;

						this.list_columns = data._listColumns
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

						//stateにセット
						this.$store.commit('setPosts', data)
						this.show = true;

						//親コンポーネントの関数実行
						this.$emit('getposts');
					}else if(res.data.posts.data.length == 0 && res.status == 200 && this.current_page > 1){
						//記事無い場合ページング繰り下げ
						var page = this.current_page-1;
						this.get_posts(page, this.searchValue);
						return false;
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
					//this.$router.push('/wow/login')
					console.log(error);
				});
			}
		}
	}
</script>
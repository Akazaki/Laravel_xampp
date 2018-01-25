<template>
	<div id="BlogBox">
		<header>
			<p id="Logo">
				<router-link :to="'/'">
					Vue BLOG
				</router-link>
			</p>
			<div class="button_green">
				<router-link :to="'/wow/login'">
					LOGIN
				</router-link>
			</div>
		</header>
		<div class="postContent">
			<div class="postList">
				<template v-if="show">
					<ul>
						<template v-for="post in posts">
							<li class="posts">
								<p class="title_box">
									<router-link :to="'/post/' + post.id">{{post.label_text}}</router-link>
								</p>
								<time class="time_box">{{post.created_at}}</time>
							</li>
						</template>
					</ul>
					<div v-if="isEndPage">
						<div class="button_green">
							<a href="javascript:void(0);" v-on:click="getPosts(current_page+1)">
								MORE
							</a>
						</div>
					</div>
				</template>
				<template v-else>
					<loadingsmall></loadingsmall>
				</template>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		created() {
			this.getPosts();
		},
		data() {
			return {
				posts: [],
				current_page: 1,//現在のページ
				show: false,
				isEndPage: false,
				page: 1,
			}
		},
		methods: {
			getPosts(page) {
				axios.post('/api/wow/publishPostList', {page: page})
				.then(res => {
					if(res.data !== undefined && res.status == 200 && res.data.posts.data.length > 0){
						this.show = true;
						var data = res.data;
						var postsdata = data.posts;

						this.posts = this.posts.concat(postsdata.data);
						this.current_page = postsdata.current_page;
						this.page_length = Math.ceil(postsdata.total / postsdata.per_page);

						//次のページがあるか
						this.isEndPage = postsdata.next_page_url ? true : false;

					}else if(res.data.posts.data.length == 0 && res.status == 200 && this.current_page > 1){
						//記事無い場合
						return false;
					}else{
						//this.$router.push('/wow/login')
					}
				}).catch(error => {
					console.log(error);
				});
			}
		}
	}
</script>
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
			<template v-if="show">
				<template v-if="post">
					<div class="post">
						<div class="title_box">
							{{post.label_text}}
						</div>
						<time class="time_box">
							<p>{{post.created_at}}</p>
						</time>
						<div class="img_box">
							<img :src="post.main_file" />
						</div>
						<div class="text_box">
							<vue-markdown :source="post.detail_richtext"></vue-markdown>
						</div>
					</div>
				</template>
			</template>
			<template v-else>
				<loadingsmall></loadingsmall>
			</template>
		</div>
	</div>
</template>

<script>
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import VueMarkdown from 'vue-markdown'

	export default {
		props: ['id'],
		created() {
			this.getPost(this.id);
		},
		data() {
			return {
				post: [],
				show: false,
			}
		},
		methods: {
			getPost(id) {
				axios.post('/api/wow/publishPostEdit', {id: id})
				.then(res => {
					if(res.data !== undefined && res.status == 200){
						this.show = true;
						var data = res.data;
						var postdata = data.post;

						this.post = postdata;

					}else if(res.status == 200){
						//記事無い場合
						return false;
					}else{
						//this.$router.push('/wow/login')
					}
				}).catch(error => {
					console.log(error);
				});
			}
		},
		components: {
			VueMarkdown
		}
	}
</script>
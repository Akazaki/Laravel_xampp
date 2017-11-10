<template>
	<div>
		<div id="Wrapper">
			<navbar></navbar>
			<sidenav></sidenav>

			<div id="Main">
				<div id="Postlist">
					<ul class="button_box">
						<li class="left">
							<p id="Post_title">記事編集</p>
						</li>
						<li class="left">
							<div class="button_green">
								<router-link to="/">
									プレビュー
								</router-link>
							</div>
						</li>
					</ul>

					<div id="Edit_box">
						
						<template v-if="show">
							<template v-for="(value, key) in post">
								<p class="form_title required">
									タイトル
								</p>
								<template v-if="post.errors">
								aaaaaa
								</template>
								<template v-if="key.match(/_richtext/)">
									<edit-richtext :value="{value:value, key:key}"　@ValueUpdate="value_update"></edit-richtext>
								</template>
								<template v-else-if="key.match(/_file/)">
									<edit-file :value="{value:value, key:key}"　@ValueUpdate="value_update"></edit-file>
								</template>
								<template v-else-if="key.match(/_check/)">
									<edit-check :value="{value:value, key:key}"　@ValueUpdate="value_update"></edit-check>
								</template>
								<template v-else-if="key.match(/_radio/)">
									<edit-radio :value="{value:value, key:key}"　@ValueUpdate="value_update"></edit-radio>
								</template>
								<template v-else-if="key.match(/_at/)">
									<edit-datetime :value="{value:value, key:key}"　@ValueUpdate="value_update"></edit-datetime>
								</template>
								<template v-else>
									<edit-text :value="{value:value, key:key}"　@ValueUpdate="value_update"></edit-text>
								</template>
							</template>
							<ul class="button_box">
								<li>
									<div class="button_green">
										<a href="javascript:void(0);" v-on:click="done_edit">
											保存
										</a>
									</div>
								</li>
								<li>
									<div class="button_green">
										<router-link to="/wow/posts">
											キャンセル
										</router-link>
									</div>
								</li>
							</ul>
						</template>
						<template v-else>
							<loadingsmall></loadingsmall>
						</template>
					</div>
				</div>
			</div>
			
		</div>
		<footerbar></footerbar>
	</div>
</template>

<script>
import http from '../../services/http'
import wow from '../../services/wow'
import VueRouter from 'vue-router'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import locale from 'element-ui/lib/locale/lang/ja'
import VueMarkdown from 'vue-markdown'

Vue.use(ElementUI, { locale })
Vue.use(VueRouter)
Vue.component('navbar', require('../../components/Layouts/Navbar.vue'))
Vue.component('sidenav', require('../../components/Layouts/Sidenav.vue'))
Vue.component('footerbar', require('../../components/Layouts/Footer.vue'))

// EditParts
Vue.component('edit-text', require('../../components/Layouts/EditParts/Text.vue'))
Vue.component('edit-richtext', require('../../components/Layouts/EditParts/RichText.vue'))
Vue.component('edit-file', require('../../components/Layouts/EditParts/File.vue'))
Vue.component('edit-check', require('../../components/Layouts/EditParts/Check.vue'))
Vue.component('edit-radio', require('../../components/Layouts/EditParts/Radio.vue'))
Vue.component('edit-datetime', require('../../components/Layouts/EditParts/Datetime.vue'))

	export default {
		props: ['id'],
		data (){
			return {
				post: {},//記事データ
				errors: false,
				show: false,
			}
		},
		created () {
			this.get_post(this.id);
		},
		methods: {
			 /**
			 * 記事データ取得
			 * @param {id} num - 記事id
			 */
			get_post: function(id){
				axios.post('/api/wow/postEdit', {id: id})
				.then(res => {
					if(res.data && res.status == 200){
						var data = res.data;
						this.post = data.post;
						this.show = true;
					}else{
						return false;
					}
					
				}).catch(error => {
					console.log(error);
				});
			},
			 /**
			 * 子コンポーネントから実行されるイベント
			 * @param {value} - 子から渡された値
			 * @param {key} - 書き換えるkeyの名前
			 */
			value_update: function(emit_value, emit_key) {
				if (emit_key in this.post) {
					this.post[emit_key] = emit_value;//更新
				}
			},
			 /**
			 * 記事保存
			 */
			done_edit: function() {

				// axios.post('/api/wow/postDoneEdit', {rows: this.post, id: this.id})
				// .then( 
				//     (response) => { console.log(response) },
				//     (error) => { 
				// 		console.log(error.response.data);
				// 		console.log(error.response.status);
				// 		console.log(error.response.headers);
				//     }
				// );

				axios.post('/api/wow/postDoneEdit', {rows: this.post, id: this.id},)
				.then(res => {
					if(res.data && res.status == 200){
						this.$router.push('/wow/posts')
					}else{
						return false;
					}
					
				}).catch(error => {
					if(error.response.data){
						//errortext格納
						this.errors = error.response.data.errors;
						this.post.errors = this.errors;
						this.post = this.post;
						console.log(this.post)
						// Object.keys(this.errors).forEach(function (key, i) {
						// 	self.post.errors = self.errors;
						// });
					}
					// this.$router.push('/wow/login')
				});
			},
		}
	}
</script>
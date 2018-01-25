<template>
	<div>
		<div id="Wrapper">
			<navbar></navbar>
			<sidenav></sidenav>

			<div id="Main">
				<div id="Postlist">
					<ul class="button_box">
						<li class="left">
							<p id="Post_title">編集</p>
						</li>
						<!-- <li class="left">
							<div class="button_green">
								<router-link to="/">
									プレビュー
								</router-link>
							</div>
						</li> -->
					</ul>

					<div id="Edit_box">
						
						<template v-if="show">
							<!-- <div class="error_text" v-if="errors">
								※入力に誤りがあります。
							</div> -->
							<template v-for="(value, key) in post">
								<div class="title_box">
									<p class="form_title required">
										{{value.title}}
									</p>
									<transition name="fade">
										<div class="error_text" v-if="value.error">
											{{value.error}}
										</div>
									</transition>
								</div>
								<div v-bind:class="{error:value.error}">
									<template v-if="key.match(/_richtext/)">
										<edit-richtext :value="{value:value.data, key:key}"　@ValueUpdate="value_update"></edit-richtext>
									</template>
									<template v-else-if="key.match(/_file/)">
										<edit-file :value="{value:value.data, key:key}"　@ValueUpdate="value_update"></edit-file>
									</template>
									<template v-else-if="key.match(/_check/)">
										<edit-check :value="{value:value.data, key:key}"　@ValueUpdate="value_update"></edit-check>
									</template>
									<template v-else-if="key.match(/_radio/)">
										<edit-radio :value="{value:value.data, key:key}"　@ValueUpdate="value_update"></edit-radio>
									</template>
									<template v-else-if="key.match(/_at/)">
										<edit-datetime :value="{value:value.data, key:key}"　@ValueUpdate="value_update"></edit-datetime>
									</template>
									<template v-else-if="key.match(/password/)">
										<edit-password :value="{value:value.data, key:key}"　@ValueUpdate="value_update"></edit-password>
									</template>
									<template v-else>
										<edit-text :value="{value:value.data, key:key}"　@ValueUpdate="value_update"></edit-text>
									</template>
								</div>
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
										<router-link v-bind:to="{ path: '/wow/list/'+dataName }">
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
		<!-- <footerbar></footerbar> -->
	</div>
</template>

<script>
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import locale from 'element-ui/lib/locale/lang/ja'
import VueMarkdown from 'vue-markdown'

Vue.use(ElementUI, { locale })
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
Vue.component('edit-password', require('../../components/Layouts/EditParts/Password.vue'))

	export default {
		props: ['id', 'dataName'],
		data (){
			return {
				post: {},//記事データ
				errors: false,
				show: false,
			}
		},
		created () {
			this.get_post(this.id);

			if(this.dataName === 'post' || this.dataName === 'admin'){

			}else{
				this.$router.push('/wow/login');
				return false;
			}
		},
		methods: {
			 /**
			 * 記事データ取得
			 * @param {id} num - 記事id
			 */
			get_post: function(id){
				axios.post('/api/wow/'+this.dataName+'Edit', {id: id})
				.then(res => {
					if(res.data && res.status == 200){
						var data = res.data;
						this.post = data.post;
						this.show = true;
					}else{
						return false;
					}
					
				}).catch(error => {
					if(error.response.data){
						if(error.response.data.error == 'token_not_provided'){
							//token切れ
							this.$router.push('/wow/login');
							return false;
						}
					}
				});
			},
			 /**
			 * 子コンポーネントから実行されるイベント
			 * @param {value} - 子から渡された値
			 * @param {key} - 書き換えるkeyの名前
			 */
			value_update: function(emit_value, emit_key) {
				if (emit_key in this.post) {
					this.post[emit_key].data = emit_value;//更新
				}
			},
			 /**
			 * 記事保存
			 */
			done_edit: function() {
				// this.errors = false;//エラーテキスト初期化
				var self = this;

				var tmp_postdata = this.post;//tmp変数に代入
				var tmp_postdata2 = {};

				//postデータに代入
				Object.keys(tmp_postdata).forEach(function (key, i) {
					if(tmp_postdata[key].data){
						tmp_postdata[key].post_data = tmp_postdata[key].data;//データのみ格納
						tmp_postdata2[key] = tmp_postdata[key].post_data;
					}
				});
				//postデータに「id」追加
				//tmp_postdata2.id = this.id;

				axios.post('/api/wow/'+this.dataName+'DoneEdit', {rows: tmp_postdata2, id: this.id})
				.then(res => {
					if(res.data && res.status == 200){
						this.$router.push('/wow/list/'+this.dataName);
					}else{
						return false;
					}

				}).catch(error => {
					if(error.response.data){
						
						if(error.response.data.error == 'token_not_provided' || error.response.data.error == 'token_expired'){
							//token切れ
							this.$router.push('/wow/login');
							return false;
						};

						//errortext格納
						this.errors = error.response.data.errors;

						//エラー文言追加
						Object.keys(this.post).forEach(function (key, i) {
							var key2 = 'rows.'+key;
							if(key2 in self.errors){
								self.post[key].error = '※'+self.errors[key2][0];
							}else{
								self.post[key].error = false;
							}
						});
					}
				});
			},
		}
	}
</script>
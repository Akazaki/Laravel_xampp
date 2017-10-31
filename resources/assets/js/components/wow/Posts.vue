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

						<p class="form_title required">
							タイトル
						</p>
						<div class="form_field">
							<input type="text" name="name" class="form__input" placeholder="text" required>
						</div>

						<p class="form_title">
							タイトル
						</p>
						<div class="form_field">
							<!-- <textarea name="detail_text" id="detail_text" cols="30" rows="20" required></textarea> -->
							<div id="editor">
							    <textarea class="editor" v-model="markdown_value"></textarea>
       							<vue-markdown :source="markdown_value"></vue-markdown>
							</div>
						</div>

						<p class="form_title">
							タイトル
						</p>
						<div class="form_field">
							<ul>
								<li>
									<input type="checkbox" v-bind:id="'checkid' + 1" />
									<label v-bind:for="'checkid' + 1">ssssssssssssssss</label>
								</li>
								<li>
									<input type="checkbox" v-bind:id="'checkid' + 2" />
									<label v-bind:for="'checkid' + 2">ssssssssssssssss</label>
								</li>
							</ul>
						</div>

						<p class="form_title">
							タイトル
						</p>
						<div class="form_field">
							<ul>
								<li>
									<input type="radio" name="radio" v-bind:id="'radioid' + 1" />
									<label v-bind:for="'radioid' + 1">ssssssssssssssss</label>
								</li>
								<li>	
									<input type="radio" name="radio" v-bind:id="'radioid' + 2" />
									<label v-bind:for="'radioid' + 2">ssssssssssssssss</label>
								</li>
							</ul>
						</div>

						<p class="form_title">
							タイトル
						</p>
						<div class="form_field">
							<div class="datetimepicker">
								<el-date-picker v-model="datetime_value" type="datetime" placeholder="日付の選択"></el-date-picker>
							</div>
						</div>

						<ul class="button_box">
							<li>
								<div class="button_green">
									<router-link to="/">
										保存
									</router-link>
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
					</div>
				</div>
			</div>
			
		</div>
		<footerber></footerber>
	</div>
</template>

<script>
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
Vue.component('footerber', require('../../components/Layouts/Footer.vue'))

	export default {
		props: ['id'],
		data (){
			return {
				post: {},//記事データ
				edit_columns: '',//カラムリスト
				datetime_value: '',
				markdown_value: '# hello\n:smile:',
			}
		},
	    filters: {
	        marked: marked
	    },
		created () {
			this.get_post(this.id);
		},
		computed: {
			compiledMarkdown: function () {
				return marked(this.input, { sanitize: true })
			}
		},
		methods: {
			 /**
			 * 記事データ取得
			 * @param {id} num - 記事id
			 */
			get_post(id){
				axios.post('/api/wow/postEdit', {id: id})
				.then(res => {
					if(res.data && res.status == 200){
						var data = res.data;
						this.post = data.post;
						this.edit_columns = data._editColumns
					}else{
						this.$router.push('/wow/login')
					}
					
				}).catch(error => {
					this.$router.push('/wow/login')
					console.log(error);
				});
			},
			update: _.debounce(function (e) {
				this.input = e.target.value
			}, 300)
		},
		components: {
			VueMarkdown
		}
	}
</script>
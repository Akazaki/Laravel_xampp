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
						
						<template v-for="column in edit_columns">
							<p class="form_title required">
								タイトル
							</p>
							<template v-if="column.match(/_richtext/)">
								<edit-richtext></edit-richtext>
							</template>
							<template v-else-if="column.match(/_file/)">
								<edit-file></edit-file>
							</template>
							<template v-else-if="column.match(/_check/)">
								<edit-check></edit-check>
							</template>
							<template v-else-if="column.match(/_radio/)">
								<edit-radio></edit-radio>
							</template>
							<template v-else-if="column.match(/_datetime/)">
								<edit-datetime></edit-datetime>
							</template>
							<template v-else>
								<edit-text></edit-text>
							</template>
						</template>

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
				errors: {},
				edit_columns: '',//カラムリスト
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
		}
	}
</script>
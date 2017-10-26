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
						<div class="form__field">
							<input type="text" name="name" class="form__input" placeholder="text" required>
						</div>

						<div class="form__field">
							<input type="text" name="email_text" class="form__input" required>
						</div>

						<div class="button_green">
							<router-link to="/">
								保存
							</router-link>
						</div>
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
						
						console.log(this.post)
						console.log(this.edit_columns)
					}else{
						this.$router.push('/wow/login')
					}
					
				}).catch(error => {
					this.$router.push('/wow/login')
					console.log(error);
				});
			}
		}
	}
</script>
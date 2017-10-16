<template>
	<div id="Wrapper">
		<navbar></navbar>
		<sidenav></sidenav>
		<div v-if="loginStatus">
			<div id="Postlist">
				<ul class="button_box">
					<li class="left">
						<div class="button_green">
							<a href="#">
								新規追加
							</a>
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
			            <td>Name</td>
			            <td>Description</td>
			            <td>Date Created</td>
			            <td></td>
			          </tr>  
			        </thead>
			        <tbody>
			          <tr>
			            <td><input type="checkbox"></td>
			            <td class="name-td">Last quarter revenue</td>
			            <td class="desc-td">Revenue for last quarter in state America for year 2013, with ...</td>
			            <td class="date-td">6 minutes ago <i class="fa fa-clock-o" aria-hidden="true"></i></td>
			            <td></td>
			          </tr>
			          <tr class="checked">
			            <td><input type="checkbox" checked="checked"></td>
			            <td class="name-td">Expenses in 2013</td>
			            <td class="desc-td"></td>
			            <td class="date-td">2 hours ago <i class="fa fa-clock-o" aria-hidden="true"></i></td>
			            <td></td>
			          </tr>
			          <tr>
			            <td><input type="checkbox"></td>
			            <td class="name-td">Accounting</td>
			            <td class="desc-td">Lorem ipsum dolor sit amet.</td>
			            <td class="date-td">5 hours ago <i class="fa fa-clock-o" aria-hidden="true"></i></td>
			            <td></td>
			          </tr>
			          <tr>
			            <td><input type="checkbox"></td>
			            <td class="name-td">Starbucks orders</td>
			            <td class="desc-td">Ut euismod augue ut nulla aliquam, eu congue ipsum euismod.</td>
			            <td class="date-td">12 hours ago <i class="fa fa-clock-o" aria-hidden="true"></i></td>
			            <td></td>
			          </tr>
			          <tr>
			            <td><input type="checkbox"></td>
			            <td class="name-td">East coast customers in 2012</td>
			            <td class="desc-td"></td>
			            <td class="date-td">yesterday <i class="fa fa-clock-o" aria-hidden="true"></i></td>
			            <td></td>
			          </tr>
			          <tr>
			            <td><input type="checkbox"></td>
			            <td class="name-td">Last quarter expenses</td>
			            <td class="desc-td">Lorem ipsum dolor sit amet.</td>
			            <td class="date-td">2 days ago <i class="fa fa-clock-o" aria-hidden="true"></i></td>
			            <td></td>
			          </tr>
			          <tr>
			            <td><input type="checkbox"></td>
			            <td class="name-td">HR 2013 worksheet</td>
			            <td class="desc-td">Nulla aliquam, eu congue ipsum euismod.</td>
			            <td class="date-td">2 days ago <i class="fa fa-clock-o" aria-hidden="true"></i></td>
			            <td></td>
			          </tr>
			          <tr>
			            <td><input type="checkbox"></td>
			            <td class="name-td">Salaries last quarter</td>
			            <td class="desc-td">Lorem ipsum dolor sit amet.</td>
			            <td class="date-td">1 week ago <i class="fa fa-clock-o" aria-hidden="true"></i></td>
			            <td></td>
			          </tr>
			          <tr>
			            <td><input type="checkbox"></td>
			            <td class="name-td">Accounting</td>
			            <td class="desc-td">Lorem ipsum dolor sit amet.</td>
			            <td class="date-td">5 hours ago <i class="fa fa-clock-o" aria-hidden="true"></i></td>
			            <td></td>
			          </tr>
			        </tbody>
			      </table>
			    </div> 
			</div>		  
		</div>		  
	</div>
</template>

<script>
// import http from '../../services/http'
import VueRouter from 'vue-router'
Vue.use(VueRouter)
Vue.component('navbar', require('../../components/Layouts/Navbar.vue'))
Vue.component('sidenav', require('../../components/Layouts/Sidenav.vue'))

    export default {
		data (){
			return {
				user: '',
				loginStatus: false,
			}
		},
		created () {
			this.$store.dispatch('GET_USER').then(res => {
				this.loginStatus = true
				this.user = this.$store.getters.user
			}, error => {
				this.$router.push('/wow/login')
			})
		},
	}
</script>
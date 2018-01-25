import Vue from 'vue';
import Vuex from 'vuex'
window.Vue = Vue;
import VueRouter from 'vue-router'
import http from './services/http'
Vue.component('loading', require('./components/Layouts/Loading.vue'))
Vue.component('loadingsmall', require('./components/Layouts/LoadingSmall.vue'))
require('./bootstrap')
Vue.use(VueRouter)
Vue.use(Vuex)


//状態管理
const store = new Vuex.Store({
	state: {
		user: {},//ログインユーザー
		authenticated: false,//ログイン状態
		posts: {},//記事データ
		menu: false,//メニューデータ
	},
	mutations: {
		// Userの書き換え
		setUser: function (state, payload) {
			state.user = payload,
			state.authenticated = true;
		},
		// Userの書き換え
		setPosts: function (state, payload) {
			state.posts = payload
		},
		// Menuの書き換え
		setMenu: function (state, payload) {
			state.menu = payload
		}
	},
	actions: {
		// User情報をAPIから取得
		GET_USER: function (commit) {
			return axios.get('/api/wow/getcurrentuser', {})
			.then(res => {
				// ここからコミット 引数の commit を使う
				if(res && res.data.user){
					this.commit('setUser', res.data.user)
					return res;
				}
			}).catch(error => {
				console.log(error);
			})

			// return axios.get('/api/wow/getcurrentuser', {}, res => {
			// 	// // ここからコミット 引数の commit を使う
			// 	console.log(res)
			// 	if(res && res.data.user){
			// 		console.log(res.data.user)
			// 		commit('setUser', res.data.user)
			// 	}
			// }, error => {
			// 	//console.log(res)
			// })
		},
		//ログイン成功するとstateに保持
		LOGIN: function(commit, login_param) {
			return axios.post('/api/wow/signin', login_param, res => {
				commit('setUser', res.data.user)
			}, error => {
				//console.log(res)
			})
		},
		LOGOUT: function (commit) {
			localStorage.removeItem('jwt-token')
			this.state.authenticated = false;
		},
		SET_MENU: function(commit) {
			return axios.post('/api/wow/getMenuData', {})
			.then(res => {
				// ここからコミット 引数の commit を使う
				if(res && res.data){
					this.commit('setMenu', res.data)
				}
			}).catch(error => {
				//console.log(error);
			});
		},
	},
	getters: {
		// User をそのまま使用
		user: function (state) { return state.user },
		authenticated: function (state) { return state.authenticated },
		posts: function (state) { return state.posts },
		menu: function (state) { return state.menu },
	}
})

//ルーティング
const router = new VueRouter({
	mode: 'history',
	routes: [
		{ path: '/', component: require('./components/Index.vue') },
		{ path: '/post/:id', props: true, component: require('./components/Posts.vue') },
		{ path: '/wow/login', component: require('./components/wow/Login.vue') },
		{ path: '/wow/signup', component: require('./components/wow/Signup.vue') },
		//↓ログインチェック有無をmetaに追加
		//{ path: '/wow', component: require('./components/wow/Dashboard.vue'), meta: { requiresAuth: true }},
		{ path: '/wow/list/:dataName', props: true, component: require('./components/wow/Dashboard.vue'), meta: { requiresAuth: true }},
		{ path: '/wow/edit/:dataName/:id', props: true, component: require('./components/wow/Posts.vue'), meta: { requiresAuth: true }},
		{ path: '/wow/edit/:dataName/0', props: true, component: require('./components/wow/Posts.vue'), meta: { requiresAuth: true }},
	]
})

//ログインチェック
router.beforeEach((to, from, next) => {
	http.init()//JWTokenヘッダ付与
	
	if (to.matched.some(record => record.meta.requiresAuth) && !store.state.authenticated) {//JWTチェック
		store.dispatch('GET_USER').then(res => {//API叩いてユーザーチェック
			
			if(store.state.authenticated){
				next();
			}else{
				next({ path: '/wow/login', query: { redirect: to.fullPath }});
			}
		}, error => {
			next({ path: '/wow/login', query: { redirect: to.fullPath }});
		})

	} else {
		next();
	}
});

const app = new Vue({
	store: store,
	router,
	el: '#app',
	created () {
		// userStore.init()
	}
})
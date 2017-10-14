import Vue from 'vue';
import Vuex from 'vuex'
window.Vue = Vue;
import VueRouter from 'vue-router'
// import store from './stores/userStore'
import http from './services/http'

require('./bootstrap')

Vue.use(VueRouter)
Vue.use(Vuex)

const store = new Vuex.Store({
	state: {
		user: {},//ログインユーザー
		authenticated: false,//ログイン状態
	},
	mutations: {
		// Userの書き換え
		setUser: function (state, payload) {
			state.user = payload,
			state.authenticated = true;
		},
	},
	actions: {
		// User情報をAPIから取得
		GET_USER: function (commit) {
			return axios.get('/api/wow/getcurrentuser', res => {
				// ここからコミット 引数の commit を使う
				commit('setUser', "res.data.user")
			}, error => {
			})
		},
		//ログイン成功するとstateに保持
		LOGIN: function(commit, login_param) {
			return axios.post('/api/wow/signin', login_param, res => {
				commit('setUser', res.data.user)
			}, error => {
				//console.log(res)
			})
		}
	},
	getters: {
		// User をそのまま使用
		User: function (state) { return state.user },
		authenticated: function (state) { return state.authenticated }
	}
})

const router = new VueRouter({
	mode: 'history',
	routes: [
		{ path: '/', component: require('./components/Index.vue') },
		// { path: '/about', component: require('./components/About.vue') },
		{ path: '/wow/login', component: require('./components/wow/Login.vue') },
		{ path: '/wow', component: require('./components/wow/Dashboard.vue') },
	]
})

const app = new Vue({
	store: store,
	router,
	el: '#app',
	created () {
		http.init()
		// userStore.init()
	},
	// render: h => h(require('./components/index.vue')),
})
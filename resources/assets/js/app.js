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
		user: {},
		authenticated: false,
	},
	mutations: {
		// Userの書き換え
		setUser: function (state, payload) {
			state.user = payload,
			state.authenticated = true
		}
	},
	actions: {
		// User情報をAPIから取得
		GET_USER: function (commit) {
			axios.get('/api/wow/getcurrentuser').then(function (res) {
				// ここからコミット 引数の commit を使う
				console.log('get!'+res.data.user)
				commit('setUser', res.data.user)
			}).catch(errorCb)
		}
	},
	getters: {
		// User をそのまま使用
		User: function (state) { return state.user }
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
		store.dispatch('GET_USER')
  //   	http.init()
		// userStore.init()
	},
	// render: h => h(require('./components/index.vue')),
})
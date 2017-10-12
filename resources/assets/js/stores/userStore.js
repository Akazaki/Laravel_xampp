import http from '../services/http'
import Vue from 'vue';
import Vuex from 'vuex'
window.Vue = Vue;

Vue.use(Vuex)

// var store = new Vuex.Store({
// 	state: {
// 	user: {},
// 	authenticated: true,
// 	},
// 	mutations: {
// 		// メッセージの書き換え
// 		setUser: function (state, payload) {
// 			state.user = payload,
// 			state.authenticated = true
// 		}
// 	},
// 	actions: {
// 		// メッセージを API から取得
// 		getUser: function (commit) {
// 			axios.get('/api/wow/getcurrentuser').then(function (res) {
// 			// ここからコミット 引数の commit を使う
// 			console.log('get!'+res.data.user)
// 			commit('setUser', res.data.user)
// 			})
// 		}
// 	},
// 	getters: {
// 		// User をそのまま使用
// 		User: function (state) { return state.user }
// 	}
// })

export default {
	debug: true,
	// state: {
	// 	user: {},
	// 	authenticated: false,
	// },

	//ログイン成功するとstateに保持
	login (email_text, password, successCb = null, errorCb = null) {
		var login_param = {email_text: email_text, password: password}
		http.post('/api/wow/signin', login_param, res => {
			this.state.user = res.data.user
			this.state.authenticated = true
			successCb()
		}, error => {
			errorCb()
		})
	},

	// To log out, we just need to remove the token
	logout (successCb = null, errorCb = null) {
		http.get('wow/signout', () => {
			localStorage.removeItem('jwt-token')
			this.state.authenticated = false
			successCb()
		}, errorCb)
	},

	setCurrentUser () {
		http.get('/api/wow/getcurrentuser', res => {
			this.state.user = res.data.user
			this.state.authenticated = true
		}, error => {
		})
	},

	/**
	 * Init the store.
	 */
	init () {
		this.setCurrentUser()
	}
}
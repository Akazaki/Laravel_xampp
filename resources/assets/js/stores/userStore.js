import Vuex from 'vuex'
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
		},
	},
	actions: {
		// User情報をAPIから取得
		GET_USER: function (commit) {
			axios.get('/api/wow/getcurrentuser').then(function (res) {
				// ここからコミット 引数の commit を使う
				commit('setUser', "res.data.user")
			}).catch(function (res) {
				console.log('not login')
			})
		},
		//ログイン成功するとstateに保持
		LOGIN: function(commit, email_text, password, successCb = null, errorCb = null) {
			var login_param = {email_text: email_text, password: password}
			axios.post('/api/wow/signin', login_param, res => {
				commit('setUser', res.data.user)
				//successCb()
			}, error => {
				console.log(email_text)
				errorCb()
			})
		}
	},
	getters: {
		// User をそのまま使用
		User: function (state) { return state.user }
	}
})

// export default {
// 	debug: true,
// 	// state: {
// 	// 	user: {},
// 	// 	authenticated: false,
// 	// },

// 	//ログイン成功するとstateに保持
// 	login (email_text, password, successCb = null, errorCb = null) {
// 		var login_param = {email_text: email_text, password: password}
// 		http.post('/api/wow/signin', login_param, res => {
// 			this.state.user = res.data.user
// 			this.state.authenticated = true
// 			successCb()
// 		}, error => {
// 			errorCb()
// 		})
// 	},

// 	// To log out, we just need to remove the token
// 	logout (successCb = null, errorCb = null) {
// 		http.get('wow/signout', () => {
// 			localStorage.removeItem('jwt-token')
// 			this.state.authenticated = false
// 			successCb()
// 		}, errorCb)
// 	},

// 	setCurrentUser () {
// 		http.get('/api/wow/getcurrentuser', res => {
// 			this.state.user = res.data.user
// 			this.state.authenticated = true
// 		}, error => {
// 		})
// 	},

// 	/**
// 	 * Init the store.
// 	 */
// 	init () {
// 		this.setCurrentUser()
// 	}
// }
import http from '../services/http'

export default {
	debug: true,
	state: {
		user: {},
		authenticated: false,
	},

	//ログイン成功するとstateに保持
	// login (email_text, password, successCb = null, errorCb = null) {
	// 	var login_param = {email_text: email_text, password: password}

	// 	axios.post('/api/wow/signin', login_param)
	// 	.then(login_param, res =>	{
	// 		// if(res.data.errors){
	// 		// 	console.log('error')
	// 		// }else{
	// 		this.state.user = res.data.user
	// 		this.state.authenticated = true
	// 		// 	return successCb()
	// 		// }
	// 	}, error => {
	// 		return errorCb()
	// 	})
	// },
	login (email_text, password, successCb = null, errorCb = null) {
		var login_param = {email_text: email_text, password: password}
		http.post('/api/wow/signin', login_param, res => {
			this.state.user = res.data.user
			this.state.authenticated = true
			console.log(this.state.user);
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

	// setCurrentUser () {
	// 	axios.post('/api/wow/authcheck')
	// 	.then(res => {
	// 		this.state.user = res.data
	// 		this.state.authenticated = true
	// 		//router.push('/')
	// 	})
	// },
	setCurrentUser () {
		http.get('/api/wow/authcheck', res => {
			this.state.user = res.data.user
			this.state.authenticated = true
			console.log(this.state.user);
		})
	},

	/**
	 * Init the store.
	 */
	init () {
		this.setCurrentUser()
	}
}
export default {
	debug: true,
	state: {
		user: {},
		authenticated: false,
	},

	// login (email_text, password, successCb = null, errorCb = null) {
	// 	var login_param = {email_text: email_text, password: password}

	// 	axios.post('/api/authenticate')
	// 	.then(login_param, res =>	{
	// 			this.state.user = res.data.user
	// 			this.state.authenticated = true
	// 			successCb()
	// 	}, error => {
	// 			errorCb()
	// 	})
	// },

	setCurrentUser () {
		axios.post('/api/wow/authcheck')
		.then(res => {
			console.log(res.data)
			// this.state.user = res.data.user
			// this.state.authenticated = true
		})
	},

	/**
	 * Init the store.
	 */
	init () {
		// Intercept the request to make sure the token is injected into the header.
		axios.interceptors.request.use(config => {
			config.headers['X-CSRF-TOKEN']	= window.Laravel.csrfToken
			config.headers['X-Requested-With'] = 'XMLHttpRequest'
			config.headers['Authorization']	= `Bearer ${localStorage.getItem('jwt-token')}` // これを追加
			return config
		})

		// ↓ここから追加
		// Intercept the response and ...
		axios.interceptors.response.use(response => {
			// ...get the token from the header or response data if exists, and save it.
			const token = response.headers['Authorization'] || response.data['token']
			if (token) {
			localStorage.setItem('jwt-token', token)
			}

			return response
		}, error => {
			// Also, if we receive a Bad Request / Unauthorized error
			console.log(error)
			return Promise.reject(error)
		})
	
		this.setCurrentUser()
	}
}
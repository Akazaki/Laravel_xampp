import Vue from 'vue';
window.Vue = Vue;
import VueRouter from 'vue-router'
import userStore from './stores/userStore'

require('./bootstrap')

Vue.use(VueRouter)

Vue.component('navbar', require('./components/Layouts/Navbar.vue'))

const router = new VueRouter({
	mode: 'history',
	routes: [
		{ path: '/', component: require('./components/Index.vue') },
		{ path: '/about', component: require('./components/About.vue') },
		{ path: '/wow/login', component: require('./components/wow/Login.vue') },
	]
})

const app = new Vue({
	router,
	el: '#app',
	created () {
		userStore.init()
	}
})
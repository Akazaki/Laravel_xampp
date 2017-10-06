import Vue from 'vue'
import VueRouter from 'vue-router'

require('./bootstrap');

Vue.component('example', require('./components/Example.vue'));

var vue = new Vue({
    el: '#app'
});
import './bootstrap';

import Vue from 'vue';
import store from './store/store.js';

import LoginComponent from './components/login/login.vue'

new Vue({
    el: '#login',
    store,
    render: h => h(LoginComponent)
});
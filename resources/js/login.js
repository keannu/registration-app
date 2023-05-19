import './bootstrap';

import Vue from 'vue';
import Notifications from 'vue-notification';
import store from './store/store.js';

import LoginComponent from './components/login/login.vue'

Vue.use(Notifications);

new Vue({
    el: '#login',
    store,
    render: h => h(LoginComponent)
});
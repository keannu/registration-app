import './bootstrap';

import Vue from 'vue';
import store from './store/store';

import DashboardComponent from './components/dashboard/dashboard.vue';

new Vue({
    el: '#dashboard',
    store,
    render: h => h(DashboardComponent)
});

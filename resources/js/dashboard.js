import './bootstrap';

import Vue from 'vue';
import store from './store/store';
import router from './router';
import Notifications from 'vue-notification';

import DashboardComponent from './components/dashboard/dashboard.vue';

Vue.use(Notifications);

new Vue({
    el: '#dashboard',
    router,
    store,
    render: h => h(DashboardComponent)
});

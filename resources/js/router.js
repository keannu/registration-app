import Vue from 'vue';
import Router from 'vue-router';

import MainComponent from './components/dashboard/MainComponent';
import UserListComponent from './components/dashboard/UserListComponent';

Vue.use(Router);

const router = new Router({
    mode: 'history',
    routes: [
        {
            path: '/dashboard',
            component: {
                render(c) {
                    return c('router-view');
                }
            },
            children: [
                {
                    path: '',
                    name: 'dashboard.main',
                    component: MainComponent
                },
                {
                    path: 'list',
                    name: 'dashboard.list',
                    component: UserListComponent
                }
            ]
        }
    ]
});

export default router;

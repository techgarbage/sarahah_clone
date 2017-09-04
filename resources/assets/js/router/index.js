import Vue from 'vue'

import VueRouter from 'vue-router'

import Index from '../views/Index.vue';
import Login from '../views/Login.vue';
import Register from '../views/Register.vue';
import Messages from '../views/Messages.vue';
import NewMessage from '../views/NewMessage.vue';
import ThankYou from '../views/ThankYou.vue';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            component: Index
        },
        {
            path: '/login',
            component: Login
        },
        {
            path: '/register',
            component: Register
        },
        {
            path: '/messages/:user_id',
            component: Messages
        },
        {
            path: '/new-message/:user_id',
            component: NewMessage
        },
        {
            path: '/thank-you',
            component: ThankYou
        }
    ]
});

export default router;
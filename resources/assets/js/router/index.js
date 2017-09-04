import Vue from 'vue'

import VueRouter from 'vue-router'

import Index from '../views/Index.vue';
import Login from '../views/Login.vue';
import Register from '../views/Register.vue';
import Message from '../views/Message.vue';
import NewMessage from '../views/NewMessage.vue';

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
            path: '/messages',
            component: Message
        },
        {
            path: '/new_message',
            component: NewMessage
        }
    ]
});

export default router;
import {createRouter, CreateWebHistory} from 'vue-router';

import Home from '../components/Welcome.vue'

const routes = [
    {path: '/', component:Home},
    {path: 'login', component: ()=> import('../components/Login.vue')},
    {path: 'register', component: ()=> import('../components/Register.vue')},
];

const router = createRouter({
    history: CreateWebHistory(),
    routes
});

export default router;

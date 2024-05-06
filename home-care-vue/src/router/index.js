import {createRouter, createWebHistory} from 'vue-router';

import Home from '../components/Welcome.vue'

const routes = [
    {path: '/', component: Home, name:'home'},
    {path: '/login', component: ()=> import('../components/Login.vue'), name:"login"},
    {path: '/register', component: ()=> import('../components/Register.vue'), name: 'register'},
    {path: '/phone-code', component: ()=> import('../components/PhoneCode.vue'), name: 'phone-code'},
    {path: '/email-code', component: ()=> import('../components/EmailCode.vue'), name: 'email-code'},
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;

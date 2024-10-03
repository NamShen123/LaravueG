import { createRouter, createWebHistory } from 'vue-router';
import admin from './admin.js';
import login from './login.js';
import register from './register.js';

const routes =
    [
        ...admin,
        ...login,
        ...register,
    ];

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router;
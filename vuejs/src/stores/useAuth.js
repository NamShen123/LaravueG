import { defineStore } from 'pinia';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        token: localStorage.getItem('access_token') || null,
    }),
    actions: {
        setToken(token) {
            this.token = token;
            localStorage.setItem('access_token', token);
        },
        clearToken() {
            this.token = null;
            localStorage.removeItem('access_token');
        },
    },
});
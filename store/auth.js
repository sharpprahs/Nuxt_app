// store/auth.js
import { defineStore } from 'pinia'

export const useAuthStore = defineStore({
    id: 'auth', // уникальный идентификатор хранилища
    state: () => ({
        isAuthenticated: false,
    }),
    actions: {
        initializeAuthentication() {
            this.isAuthenticated = !!localStorage.getItem('token');
        },
        logout() {
            localStorage.removeItem('token');
            this.isAuthenticated = false;
        }
    }
});

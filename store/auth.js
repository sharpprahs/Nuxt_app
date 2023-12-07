// store/auth.js
import { defineStore } from 'pinia';

export const useAuthStore = defineStore({
    id: 'auth',
    state: () => ({
        isAuthenticated: false,
    }),
    actions: {
        setAuthentication(isAuthenticated) {
            this.isAuthenticated = isAuthenticated;
        },
        logout() {
            this.isAuthenticated = false;
        }
    }

});


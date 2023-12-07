// middleware/auth.js
import { defineNuxtRouteMiddleware, useCookie } from 'nuxt/app';
import { useAuthStore } from "~/store/auth"; // Импортируем наше хранилище
const authStore = useAuthStore(); // Используем наше хранилище

export default defineNuxtRouteMiddleware(() => {
    if (process.server) {
        const cookie = useCookie('auth_token');
        if (!cookie.value) {
            authStore.setAuthentication(false);
            return { path: '/content/admin' }; // Перенаправление на страницу входа
        } else {
            authStore.setAuthentication(true);
        }
    }
});
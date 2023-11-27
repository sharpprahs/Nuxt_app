// middleware/auth.js

// middleware/auth.js
export default defineNuxtRouteMiddleware((to, from) => {
    // Проверка, выполняется ли код на стороне клиента
    if (process.client) {
        if (!!localStorage.getItem('token')) {
            console.log("Пользователь не аутентифицирован");
        } else {
            return navigateTo('/content/Admin');
        }
    }
});

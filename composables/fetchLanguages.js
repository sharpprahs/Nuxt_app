// composables/fetchLanguages.js
import {getCookie} from "cookies-next";

export const fetchLanguages = async () => {
    try {
        // Получение CSRF токена
        await $fetch(`http://localhost:8000/sanctum/csrf-cookie`,{
            method: 'GET',
            credentials: 'include',
        });

        const token = decodeURIComponent(getCookie('XSRF-TOKEN'));
        // Отправка запроса на авторизацию
        const response = await $fetch(`http://localhost:8000/api/all_languages`, {
            method: 'GET',
            credentials: 'include',
            headers: {
                'X-XSRF-TOKEN': token,
                'Accept': 'application/json, text/plain, */*',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
        });
        return response;
} catch (error){
        return [];
    }
}

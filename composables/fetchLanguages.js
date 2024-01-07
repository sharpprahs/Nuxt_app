// composables/fetchLanguages.js
import {getCookie} from "cookies-next";
import { getBaseUrl } from "~/utils/getBaseUrl.js"

export const fetchLanguages = async () => {
    try {
        const baseUrl = getBaseUrl();
        // Получение CSRF токена
        await $fetch(`${baseUrl}/sanctum/csrf-cookie`,{
            method: 'GET',
            credentials: 'include',
        });

        const token = decodeURIComponent(getCookie('XSRF-TOKEN'));
        // Отправка запроса на авторизацию
        const response = await $fetch(`${baseUrl}/api/all_languages`, {
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

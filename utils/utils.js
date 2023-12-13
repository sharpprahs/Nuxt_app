// utils.js
import { getBaseUrl } from "~/utils/getBaseUrl.js"

export async function fetchCsrfToken() {


    const baseUrl = getBaseUrl();

    await $fetch(`${baseUrl}/api/sanctum/csrf-cookie`, {
        method: 'GET',
        credentials: 'include',
    });
}

// utils.js
export async function fetchCsrfToken() {
    await $fetch(`http://localhost:8000/sanctum/csrf-cookie`, {
        method: 'GET',
        credentials: 'include',
    });
}

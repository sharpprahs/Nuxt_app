<template>
  <div class="authorization_panel">
    <h1 class="msb">Linvistics <span class="mm">Вход в систему</span></h1>
    <form action="" class="form_authorization mr" @submit.prevent="login">
     <div class="form_authorization__item">
       <label for="login">Логин</label>
       <input v-model="loginData.name" placeholder="Введите логин" type="text" id="login" class="mr login"/>
     </div>
      <div class="form_authorization__item">
        <label for="password">Пароль</label>
        <div class="password_container">
          <input v-model="loginData.password" placeholder="Введите пароль" :type="type_password" id="password" class="mr form_authorization__item__password"/>
          <button class="show_password" @click.prevent="show_password"></button>
        </div>
      </div>
      <div v-if="showError" class="error-message">{{ errorMessage }}</div>
      <button class="authorization_button mr" type="submit"><span>Войти</span></button>
    </form>
  </div>
</template>

<script setup>
import {ref} from 'vue'
import { useRouter } from 'vue-router';
import { fetchCsrfToken } from '~/utils/utils.js';
// import axios from 'axios';
import { useAuthStore } from "~/store/auth"; // Импортируем наше хранилище
const authStore = useAuthStore(); // Используем наше хранилище
// import { useRuntimeConfig } from '#imports'; // Импортирует конфигурацию Nuxt
import { getCookie } from 'cookies-next'; // Импорт функции для получения кук

const loginData = ref({
  name: '',
  password: ''
});
const type_password = ref('password');
const showError = ref(false);
const errorMessage = ref('');
const router = useRouter();


function show_password() {
  document.querySelector('.show_password').classList.toggle('_active');
    type_password.value = type_password.value === 'password' ? 'text' : 'password';
}

async function login() {
  // const config = useRuntimeConfig();
  if (!loginData.value.name || !loginData.value.password) {
    showError.value = true;
    errorMessage.value = "Пожалуйста, заполните все поля.";
    return;
  }

  try {
    // Получение CSRF токена
    await fetchCsrfToken();
    // Отправка запроса на авторизацию
    const response = await $fetch(`http://localhost:8000/api/login`, {
      method: 'POST',
      credentials: 'include',
      headers: {
        'X-XSRF-TOKEN': decodeURIComponent(getCookie('XSRF-TOKEN')),
        'Accept': 'application/json, text/plain, */*',
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
      },
      body: loginData.value, // Теперь мы передаем объект напрямую
    });

    // Проверка успешной авторизации
    if (response && response.message === 'Авторизация успешна') {
      router.push('/content/Admin_panel');
      authStore.setAuthentication(true); // Устанавливаем аутентификацию в true
      // Установить состояние аутентификации при успешном входе
      localStorage.setItem('isAuthenticated', '1');
      // console.log("Аутентификация прошла успешно");
    }
  } catch (error) {
    if (error.response) {
      switch (error.response.status) {
        case 401:
          errorMessage.value = "Неверный пароль";
          break;
        case 404:
          errorMessage.value = "Пользователь не существует";
          break;
        default:
          errorMessage.value = "Произошла ошибка аутентификации";
      }
    } else {
      errorMessage.value = "Ошибка соединения с сервером";
    }
    showError.value = true;
  }
}
</script>
<style scoped>
</style>
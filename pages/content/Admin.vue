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
import axios from 'axios';
import { useAuthStore } from "~/store/auth"; // Импортируем наше хранилище
const authStore = useAuthStore(); // Используем наше хранилище

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
  if (!loginData.value.name || !loginData.value.password) {
    showError.value = true;
    errorMessage.value = "Пожалуйста, заполните все поля.";
    return;
  }

  try {
    const response = await axios.post('http://localhost:8000/api/login', loginData.value);

    if (response.data && response.data.token) {
      localStorage.setItem('token', response.data.token);
      router.push('/content/Admin_panel');
      // Вызовите мутацию для обновления состояния аутентификации в store
      authStore.initializeAuthentication(); // Устанавливаем аутентификацию в true
      errorMessage.value = null;
      showError.value = false;
      // В функции login
      console.log("Аутентификация:", authStore.isAuthenticated);
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
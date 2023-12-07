<template>
<footer>
<div class="footer_container mr">
  <NuxtLink to="/" class="home_page mm"><span class="mcfb">LIN</span><span class="mc">VISITICS</span><br>Речевой тренажёр</NuxtLink>
  <div class="footer_information">
    <div class="copyright_container">
      <div class="copyright_title mm">
        Авторские права
      </div>
      <div class="copyright_text">
        Сайт "Lingvistics" © 2023 является объектом авторского права. Все материалы, размещенные на сайте, включая тексты, изображения, видео, аудио и другие элементы, защищены законами об авторском праве.
        Пожалуйста, примите во внимание, что любое использование, воспроизведение, копирование или распространение любой части сайта без нашего явного разрешения может являться нарушением авторских прав. Мы строго следим за нарушениями авторских прав и применяем все возможные меры для защиты нашего контента.
        Если вы заинтересованы в использовании нашего контента, пожалуйста, свяжитесь с нами и получите наше явное разрешение на использование материалов. Мы будем рады обсудить с вами любые вопросы и возможности сотрудничества.
      </div>
    </div>
    <div class="contact_adn_admin_panel_container">
<div class="footer_content_container">
 <div class="footer_title mm">Контакты</div>
  <ul class="contact_links_container">
    <li><a href="sd" target="_blank"> <img src="../assets/images/svg/tg.svg" alt="Telegram account Linvistics"></a></li>
    <li><a href="dd" target="_blank"><img src="../assets/images/svg/dzen.svg" alt="Dzen account Linvistics"></a></li>
    <li><a href="zz" target="_blank"><img src="../assets/images/svg/vk.svg" alt="Vk account Linvistics"></a></li>
  </ul>
</div>
      <div class="footer_content_container">
        <div class="footer_title mm">Админ панель</div>
        <NuxtLink v-if="authStore.isAuthenticated" @click="login_acc" class="mcfb cp mm">Перейти</NuxtLink>
        <NuxtLink  v-if="!authStore.isAuthenticated"  class="authorization_admin_panel_button_footer" @click="login_acc">Войти</NuxtLink>
        <NuxtLink  v-if="authStore.isAuthenticated"  class="authorization_admin_panel_button_footer bc_red" @click="logout">Выйти</NuxtLink>
      </div>
    </div>

    </div>
</div>
  <div class="gmail_container">
    <a class="mm" href="mailto:lingvistics@gmail.com">Linvisticsail@gmail.com</a>
  </div>
</footer>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
const router = useRouter();
import {useCookies} from "vue3-cookies";
 import axios from "axios";
import { useAuthStore } from "~/store/auth"; // Импортируем наше хранилище
import { getCookie } from 'cookies-next'; // Импорт функции для получения кук
const authStore = useAuthStore(); // Используем наше хранилище
// const isAuthenticated = ref(false);

const { cookies } = useCookies();

// definePageMeta({
//   middleware: 'check-auth'
// });
// onMounted(() => {
//   authStore.setAuthentication(!!cookies.get('token'));
// });

async function login_acc(){
  const isAuthenticated = localStorage.getItem('isAuthenticated');
  if(isAuthenticated === '1'){
    authStore.setAuthentication(true);
    router.push('/content/Admin_panel'); // Перенаправляем пользователя на главную страницу
  } else{
    authStore.setAuthentication(false);
    router.push('/content/admin'); // Перенаправляем пользователя на главную страницу
  }
}
async function logout() {
  try {
    // Получение CSRF токена
    await $fetch(`http://localhost:8000/sanctum/csrf-cookie`,{
      method: 'GET',
      credentials: 'include',
    });

    const token = decodeURIComponent(getCookie('XSRF-TOKEN'));
    console.log('CSRF token received:', token);

    // Отправляем запрос на выход из системы на сервер
    const response = await fetch(`http://localhost:8000/api/logout`, {
      method: 'POST',
      credentials: 'include', // Важно для кросс-доменных запросов
      headers: {
        'X-XSRF-TOKEN': token,
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
      },
    });

    // Проверяем успешность запроса
    if (!response.ok) {
      console.log(response)
      throw new Error('Ошибка при выходе');
    }

    // Удаление куки с токеном после успешного выхода
    const cookie = useCookie('auth_token');
    cookie.value = null;
    // Сбросить состояние аутентификации при выходе
    localStorage.removeItem('isAuthenticated');


    // Обновление состояния аутентификации в хранилище
    authStore.logout();

    // Перенаправление пользователя на главную страницу
    router.push('/content/admin');
    // Получение CSRF токена
    await $fetch(`http://localhost:8000/sanctum/csrf-cookie`,{
      method: 'GET',
      credentials: 'include',
    });

  } catch (error) {
    console.error('Ошибка при выходе:', error);
  }
}
</script>

<style scoped>

</style>
<template>
<footer>
<div class="footer_container mr">
  <NuxtLink to="/" class="home_page mm"><span class="img_logo"></span><span>Linvistics</span></NuxtLink>
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
        <NuxtLink  v-if="!authStore.isAuthenticated"  class="authorization_admin_panel_button_footer" to="/content/Admin">Войти</NuxtLink>
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
import axios from "axios";
import { useAuthStore } from "~/store/auth"; // Импортируем наше хранилище
const authStore = useAuthStore(); // Используем наше хранилище
const isAuthenticated = ref(false);

onMounted(() => {
  authStore.isAuthenticated = !!localStorage.getItem('token');
});

async function logout() {
  try {
    // Отправляем запрос на выход из системы на сервер
    await axios.post('http://localhost:8000/api/logout', {}, {
      headers: {
        'Authorization': `Bearer ${localStorage.getItem('token')}`
      }
    });

    authStore.logout(); // Вызываем действие logout в нашем хранилище
    // Перенаправляем пользователя на главную страницу
    router.push('/content/admin');
  } catch (error) {
    console.error('Ошибка при выходе:', error);
  }
}
</script>

<style scoped>

</style>
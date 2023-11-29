<template>
<div
id="Header"
class="header_menu_navigation_pc_container"
>
  <div class="header_menu_navigation_pc">
    <NuxtLink to="/" class="home_page"><span class="mcfb">LIN</span><span class="mc">VISITICS</span><br>Речевой тренажёр</NuxtLink>
    <ul class="header_choice_page mr">
<li>
  <NuxtLink to="/content/Exercises" :class="{ 'active_page': $route.path === '/content/Exercises' }">
    Упражнения
  </NuxtLink>
</li>
      <li>
        <NuxtLink @click="showMobileMenu = false">
          О проекте
        </NuxtLink>
      </li>
      <li>
        <a class="contact_links">Контакты</a>
        <ul class="dropdown">
          <li><a href="#" class="tg_before">Telegram</a></li>
          <li><a href="#" class="vk_before">VK</a></li>
          <li><a href="#" class="dzen_before">Dzen</a></li>
        </ul>
      </li>
      <li>
        <a href="" class="switch_mode_dl msb">Dark</a>
      </li>
    </ul>

<!--mobile_menu-->
    <div class="menu_icon" :class="{ '_active': showMobileMenu === true  }" @click="showNav"><span></span></div>
  </div>
  <nav class="mobile_navigation" v-if="showMobileMenu">
    <ul class="mm">
      <li>
        <NuxtLink to="/" :class="{ 'active_page': $route.path === '/' }" @click="showMobileMenu = false">
          Главная
        </NuxtLink>
      </li>
      <li>
        <NuxtLink to="/content/Exercises" :class="{ 'active_page': $route.path === '/content/Exercises' }" @click="showMobileMenu = false">
          Упражнения
        </NuxtLink>
      </li>
      <li>
        <NuxtLink @click="showMobileMenu = false">
          О нас
        </NuxtLink>
      </li>
      <li>
        <ul class="contact_links_container">
          <li><a href="sd" target="_blank"> <img src="../assets/images/svg/tg.svg" alt="Telegram account Linvistics"></a></li>
          <li><a href="dd" target="_blank"><img src="../assets/images/svg/dzen.svg" alt="Dzen account Linvistics"></a></li>
          <li><a href="zz" target="_blank"><img src="../assets/images/svg/vk.svg" alt="Vk account Linvistics"></a></li>
        </ul>
      </li>
      <li class="dev mr">
        <a href="https://t.me/sharpsss" target="_blank">sharpsss.dev</a>
      </li>
    </ul>
  </nav>
</div>
</template>

<script setup>
import { ref,watch  } from 'vue';

// Reactive variable for tracking the visibility of the mobile menu
const showMobileMenu = ref(false);

watch(showMobileMenu, (newValue) => {
  const body = document.body;
  if (newValue) {
    body.classList.add('lock');
  } else {
    body.classList.remove('lock');
  }
});

// Method to toggle the mobile menu's visibility
const showNav = () => {
  showMobileMenu.value = !showMobileMenu.value;
};
</script>


<style scoped>

</style>
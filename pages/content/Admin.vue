<template>
  <div class="authorization_panel">
    <h1 class="msb">Linvistics <span class="mm">Вход в систему</span></h1>
    <form action="" class="form_authorization mr" @submit.prevent>
     <div class="form_authorization__item">
       <label for="login">Логин</label>
       <input placeholder="Введите логин" type="email" id="login" class="mr login"/>
     </div>
      <div class="form_authorization__item">
        <label for="password">Пароль</label>
        <div class="password_container">
          <input placeholder="Введите пароль" :type="type_password" id="password" class="mr form_authorization__item__password"/>
          <button class="show_password" @click.prevent="show_password"></button>
        </div>
      </div>
      <NuxtLink class="authorization_button mr" to="/content/Admin_panel"><span>Войти</span></NuxtLink>
    </form>
  </div>
</template>




<script setup>
import {ref} from 'vue'

let type_password = ref('password');
function show_password(){
  document.querySelector('.show_password').classList.toggle('_active');
  type_password.value = type_password.value === 'password' ? 'text' : 'password';
}

</script>

<style scoped>
</style>
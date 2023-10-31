<template>
<div
id="TopNav"
class="navigation_menu__container"
>
<div class="navigation_menu">

<NuxtLink to="/" class="general_page"><img src="../assets/images/logo.svg" alt="" ><span>Sharp</span></NuxtLink>
<ul>
  <li><NuxtLink
      to="/content/Posts"
      class="general_page"
      :class="{ 'gen_active': $route.path === '/content/Posts' }"
  ><span>posts</span></NuxtLink></li>
  <li><NuxtLink to="/content/About"
                :class="{ 'gen_active': $route.path === '/content/About' }"
                class="general_page"
  ><span>about</span></NuxtLink></li>
</ul>
</div>


</div>
</template>

<script setup lang="ts">
</script>


<style scoped>

</style>
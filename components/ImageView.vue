<template>
  <div class="container_component">
    <img :src="`${baseUrl}/tasks/img/${props.item.content_name}`
" alt="Изображение текущего упражнения">
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { getBaseUrl } from "~/utils/getBaseUrl.js"
const props = defineProps({
  item: Object
});
const baseUrl= ref(getBaseUrl())
</script>

<template>
  <div class="container_component">
    <label class="input-file">
      <input type="file" @change="handleFileUpload" accept="video/*" name="file" hidden>
      <span class="input-file-btn">Загрузить <span class="format mm">mp4</span></span>
      <span class="input-file-text">{{ selectedFileName }}</span>
    </label>
    <video :src="`${baseUrl}/tasks/video/${props.item.content_name}`" controls></video>
  </div>
</template>

<script setup>
import {ref} from 'vue';
import axios from 'axios';
import {getCookie} from "cookies-next";
import { getBaseUrl } from "~/utils/getBaseUrl.js"
import {fetchCsrfToken} from "~/utils/utils.js";
const selectedFileName = ref(null);
// data: content_name,type
const props = defineProps({
  item: Object
});
// const videoUrl = computed(() => {
//   return `${window.location.origin}/_nuxt/assets/tasks/video/${props.item.content_name}`;
// });
// Correctly import all images in the directory
// const videoUrl = computed(() => {
//   return new URL(`/assets/tasks/video/${props.item.content_name}`, import.meta.url).href;
// });
const baseUrl= ref(getBaseUrl())
const handleFileUpload = async (event) => {
  const file = event.target.files[0];
  if (!file) {
    selectedFileName.value = 'Вы не загрузили файл';
    return;
  }
  selectedFileName.value = file.name; // Обновление имени файла для отображения в интерфейсе

  const formData = new FormData();
  formData.append('video', file);

  try {
    // Получение CSRF токена
    await fetchCsrfToken();
    // Отправка запроса на авторизацию
    const baseUrl = getBaseUrl();

    const response = await axios.post(`${baseUrl}/api/upload-video`, formData, {
      withCredentials: true,
      headers: {
        'X-XSRF-TOKEN': decodeURIComponent(getCookie('XSRF-TOKEN')),
        'Content-Type': 'multipart/form-data'
      }
    });

    // Обновите содержимое задания видео URL после загрузки файла
    props.item.content_name = response.data.filename;
  } catch (error) {
    if (error.response.status === 422){
      selectedFileName.value = 'Для загрузки нужен mp4';
    }
    if (error.response.status === 419){
      selectedFileName.value = 'Слишком большой размер файла';
    }
  }
};
</script>
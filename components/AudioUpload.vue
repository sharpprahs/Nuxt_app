<template>
  <div class="container_component">
    <label class="input-file">
      <input type="file" @change="handleAudioUpload" accept="audio/mp3" name="audio" hidden>
      <span class="input-file-btn">Загрузить <span class="format mm">mp3</span></span>
      <span class="input-file-text">{{ selectedFileName }}</span>
    </label>
    <audio :src="`${baseUrl}/tasks/audio/${props.item.content_name}`" controls></audio>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import {getCookie} from "cookies-next";
import { getBaseUrl } from "~/utils/getBaseUrl.js"
import {fetchCsrfToken} from "~/utils/utils.js";
const selectedFileName = ref('Выберите аудио');
const props = defineProps({
  item: Object
});
// const audioUrl = computed(() => {
//   return `${window.location.origin}/_nuxt/assets/tasks/audio/${props.item.content_name}`;
// });
// const audioUrl = computed(() => {
//   return new URL(`/assets/tasks/audio/${props.item.content_name}`, import.meta.url).href;
// });
const baseUrl= ref(getBaseUrl())
const handleAudioUpload = async (event) => {
  const file = event.target.files[0];
  if (!file) {
    selectedFileName.value = 'Вы не загрузили файл';
    return;
  }
  selectedFileName.value = file.name;

  const formData = new FormData();
  formData.append('audio', file);

  try {
    // Получение CSRF токена
    await fetchCsrfToken();
    const baseUrl = getBaseUrl();
    // Отправка запроса на авторизацию
    const response = await axios.post(`${baseUrl}/api/upload-audio`, formData, {
      withCredentials: true,
      headers: {
        'X-XSRF-TOKEN': decodeURIComponent(getCookie('XSRF-TOKEN')),
        'Content-Type': 'multipart/form-data'
      }
    });

    props.item.content_name = response.data.filename;
  } catch (error) {
    if (error.response.status === 422){
      selectedFileName.value = 'Для загрузки нужен mp3';
    }
    if (error.response.status === 419){
      selectedFileName.value = 'Слишком большой размер файла';
    }
  }
};
</script>

<template>
  <div class="container_component">
    <label class="input-file">
      <input type="file" @change="handleImageUpload" accept="image/png, image/jpeg, image/webp" name="image" hidden>
      <span class="input-file-btn">Загрузить <span class="format mm">png, webp, jpg</span></span>
      <span class="input-file-text">{{ selectedFileName }}</span>
    </label>
    <img :src="`${baseUrl}/tasks/img/${props.item.content_name}`
" alt="Загруженное изображение">
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import {getCookie} from "cookies-next";
import { getBaseUrl } from "~/utils/getBaseUrl.js"
import {fetchCsrfToken} from "~/utils/utils.js";

const selectedFileName = ref('Выберите изображение');
const props = defineProps({
  item: Object
});
const baseUrl= ref(getBaseUrl())

// const imgUrl = computed(() => {
//   return new URL(`/assets/tasks/img/${props.item.content_name}`, import.meta.url).href;
// });

const handleImageUpload = async (event) => {
  const file = event.target.files[0];
  if (!file) {
    selectedFileName.value = 'Вы не загрузили файл';
    return;
  }
  selectedFileName.value = file.name;

  const formData = new FormData();
  formData.append('image', file);

  try {
    // Получение CSRF токена
    await fetchCsrfToken();
    // Отправка запроса на авторизацию
    const baseUrl = getBaseUrl();

    const response = await axios.post(`${baseUrl}/api/upload-image`, formData, {
      withCredentials: true,
      headers: {
        'X-XSRF-TOKEN': decodeURIComponent(getCookie('XSRF-TOKEN')),
        'Content-Type': 'multipart/form-data'
      }
    });

    props.item.content_name = response.data.filename;
  } catch (error) {
    if (error.response.status === 422){
      selectedFileName.value = 'Для загрузки нужен jpg,webp,png';
    }
    if (error.response.status === 419){
      selectedFileName.value = 'Слишком большой размер файла';
    }
  }
};
</script>

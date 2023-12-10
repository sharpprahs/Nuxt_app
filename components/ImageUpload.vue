<template>
  <div class="container_component">
    <label class="input-file">
      <input type="file" @change="handleImageUpload" accept="image/png, image/jpeg, image/webp" name="image" hidden>
      <span class="input-file-btn">Загрузить изображение</span>
      <span class="input-file-text">{{ selectedFileName }}</span>
    </label>
    <img :src="imgUrl" alt="Загруженное изображение">
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import {getCookie} from "cookies-next";

const selectedFileName = ref('Выберите изображение');
const props = defineProps({
  item: Object
});

const imgUrl = computed(() => {
  return new URL(`/assets/tasks/img/${props.item.content_name}`, import.meta.url).href;
});

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
    await $fetch(`http://localhost:8000/sanctum/csrf-cookie`, {
      method: 'GET',
      credentials: 'include',
    });

    const response = await axios.post('http://localhost:8000/api/upload-image', formData, {
      withCredentials: true,
      headers: {
        'X-XSRF-TOKEN': decodeURIComponent(getCookie('XSRF-TOKEN')),
        'Content-Type': 'multipart/form-data'
      }
    });

    props.item.content_name = response.data.path;
  } catch (error) {
    console.error('Ошибка при загрузке изображения:', error);
    selectedFileName.value = 'Ошибка загрузки';
  }
};
</script>

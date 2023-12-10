<template>
  <div class="container_component">
    <label class="input-file">
      <input type="file" @change="handleAudioUpload" accept="audio/mp3" name="audio" hidden>
      <span class="input-file-btn">Загрузить аудио</span>
      <span class="input-file-text">{{ selectedFileName }}</span>
    </label>
    <audio :src="audioUrl" controls></audio>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import {getCookie} from "cookies-next";

const selectedFileName = ref('Выберите аудио');
const props = defineProps({
  item: Object
});
// const audioUrl = computed(() => {
//   return `${window.location.origin}/_nuxt/assets/tasks/audio/${props.item.content_name}`;
// });
const audioUrl = computed(() => {
  return new URL(`/assets/tasks/audio/${props.item.content_name}`, import.meta.url).href;
});
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
    await $fetch(`http://localhost:8000/sanctum/csrf-cookie`, {
      method: 'GET',
      credentials: 'include',
    });

    const response = await axios.post('http://localhost:8000/api/upload-audio', formData, {
      withCredentials: true,
      headers: {
        'X-XSRF-TOKEN': decodeURIComponent(getCookie('XSRF-TOKEN')),
        'Content-Type': 'multipart/form-data'
      }
    });

    props.item.content_name = response.data.path;
  } catch (error) {
    console.error('Ошибка при загрузке аудио:', error);
    selectedFileName.value = 'Ошибка загрузки';
  }
};
</script>

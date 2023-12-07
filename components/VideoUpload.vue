<template>
  <div>
    <input type="file" @change="handleFileUpload" accept="video/*">
    <video :src="item.content" controls></video>
  </div>
</template>

<script setup>
import { ref, defineEmits } from 'vue';

const props = defineProps({
  item: Object
});

const handleFileUpload = (event) => {
  // Логика загрузки видео файла
};
</script>

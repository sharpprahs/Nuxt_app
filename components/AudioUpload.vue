<template>
  <div>
    <input type="file" @change="handleFileUpload" accept="audio/*">
    <audio :src="item.content" controls></audio>
  </div>
</template>

<script setup>
import { ref, defineEmits } from 'vue';

const props = defineProps({
  item: Object
});

const handleFileUpload = (event) => {
  // Логика загрузки аудио файла
};
</script>

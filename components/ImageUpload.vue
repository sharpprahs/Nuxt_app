<template>
  <div>
    <input type="file" @change="handleFileUpload" accept="image/png, image/jpeg, image/webp">
    <img :src="item.content" alt="Загруженное изображение">
  </div>
</template>

<script setup>
import { ref, defineProps, defineEmits } from 'vue';

const props = defineProps({
  item: Object
});

// Создаем функцию emit с помощью defineEmits
const emit = defineEmits(['file-uploaded']);

const handleFileUpload = (event) => {
  const file = event.target.files[0];
  // Логика загрузки файла
  // Предполагаем, что после загрузки вы хотите отправить обновленный item обратно
  const updatedItem = { ...props.item, content: 'новый путь к файлу после загрузки' };

  // Используйте emit для отправки события 'file-uploaded' с обновленным item
  emit('file-uploaded', updatedItem);
};
</script>

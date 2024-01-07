<template>
  <div class="container_component">
    <audio :src="`${baseUrl}/tasks/audio/${props.item.content_name}`" controls></audio>
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

<template>
  <div class="container_component">
    <video :src="`${baseUrl}/tasks/video/${props.item.content_name}`" controls></video>
  </div>
</template>

<script setup>
import {ref} from 'vue';

import { getBaseUrl } from "~/utils/getBaseUrl.js"

// data: content_name,type
const props = defineProps({
  item: Object
});

const baseUrl= ref(getBaseUrl())
</script>
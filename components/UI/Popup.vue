<template>
  <div v-if="show" class="popup-background">
    <div class="container_popup">
      <div class="container_popup__title_container">
        <div class="popup_title">{{ titlePopup }}</div>
        <button class="popup_close" @click="closePopup"></button>
      </div>
      <slot></slot>
    </div>
  </div>
</template>

<script>
import { toRefs } from 'vue';

export default {
  props: {
    show: Boolean,
    title_popup: String,
  },
  setup(props, { emit }) {
    const { show, title_popup } = toRefs(props);

    const closePopup = () => {
      emit("close");
    };

    // Возвращаемые свойства должны быть объектом
    return {
      show,
      titlePopup: title_popup,
      closePopup,
    };
  },
};
</script>

<style scoped>
</style>

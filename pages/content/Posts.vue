<template>
Список
  <ul>
    <li v-for="bank in data" :key="bank.id">
      <h2>{{ bank.title }}</h2>
      <pre>{{ bank.text}}</pre>
    </li>
  </ul>
</template>

<script>
import axios from 'axios';
export default {
  name: "admin_panel",
  data() {
    return {
      data : [],
    }
  },
  methods: {
    async fetchDataFromAPI() {
      try {
        const response = await fetch("http://127.0.0.1:8000/api/posts");
        if (response.ok) {
          this.data = await response.json();
        } else {
          console.error("Произошла ошибка при получении данных с API.");
        }
      } catch (error) {
        console.error("Произошла ошибка:", error);
      }
    },
  },
  created() {
    this.fetchDataFromAPI();
  }

}

</script>

<style scoped>

</style>
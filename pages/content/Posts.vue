<template>
  Список
  <ul>
    <li v-for="bank in product" :key="bank.id">
      <h2>{{ bank.title }}</h2>
      <pre>{{ bank.text}}</pre>
    </li>
  </ul>
</template>

<script setup>
const id = ref(1)
const { data: product, error } = await useFetch(() => `https://sharpsss.ru/api/posts`)

</script>

<style scoped>

</style>

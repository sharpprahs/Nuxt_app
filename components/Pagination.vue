<template>
  <nav aria-label="Page navigation">
    <ul class="pagination">
      <!-- Предыдущая страница -->
      <li class="page-item" :class="{ disabled: currentPage <= 1 }" v-if="firstValue">
        <a class="page-link" href="#" @click.prevent="setCurrentPage(1)">
          «
        </a>
      </li>
      <li class="page-item" :class="{ disabled: currentPage <= 1 }">
        <a class="page-link page-link-left" href="#" @click.prevent="setCurrentPage(currentPage - 1)">
          <img src="../assets/images/svg/arrow.svg" alt="Вернуться к предыдущим заданиям">
        </a>
      </li>
      <!-- Начальное многоточие -->
<!--      <li v-if="showInitialEllipsis" class="page-item ellipsis">-->
<!--        <span class="page-link">...</span>-->
<!--      </li>-->
      <!-- Номера страниц -->
      <li
          v-for="page in pageNumbersToShow"
          :class="{ 'page-item': true, active: currentPage === page }"
          :key="page"
      >
        <a class="page-link" href="#" @click.prevent="setCurrentPage(page)">
          {{ page }}
        </a>
      </li>
      <!-- Конечное многоточие -->
<!--      <li v-if="showFinalEllipsis" class="page-item ellipsis">-->
<!--        <span class="page-link">...</span>-->
<!--      </li>-->
      <!-- Следующая страница -->
      <li class="page-item" :class="{ disabled: currentPage >= pageCount }">
        <a class="page-link" href="#" @click.prevent="setCurrentPage(currentPage + 1)">
          <img src="../assets/images/svg/arrow.svg" alt="Перейти к следующим заданиям">
        </a>
      </li>
      <li class="page-item" :class="{ disabled: currentPage >= pageCount }" v-if="lastValue">
        <a class="page-link" href="#" @click.prevent="setCurrentPage(pageCount)">
          »
        </a>
      </li>
    </ul>
  </nav>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  totalElements: Number,
  amountOnPage: Number,
  lastValue: Boolean,
  firstValue: Boolean,
  currentPage: Number
});

const emit = defineEmits(['update:currentPage']);

const pageCount = computed(() => Math.ceil(props.totalElements / props.amountOnPage));

const maxPageNumbersToShow = 5;

const pageNumbersToShow = computed(() => {
  let pages = [];
  let startPage, endPage;

  if (pageCount.value <= maxPageNumbersToShow) {
    // Меньше страниц, чем максимальное количество кнопок
    startPage = 1;
    endPage = pageCount.value;
  } else {
    // Больше страниц, показываем эллипсы и сокращаем количество кнопок
    const maxPagesBeforeCurrentPage = Math.floor(maxPageNumbersToShow / 2);
    const maxPagesAfterCurrentPage = Math.ceil(maxPageNumbersToShow / 2) - 1;
    if (props.currentPage <= maxPagesBeforeCurrentPage) {
      // Первые страницы
      startPage = 1;
      endPage = maxPageNumbersToShow;
    } else if (props.currentPage + maxPagesAfterCurrentPage >= pageCount.value) {
      // Последние страницы
      startPage = pageCount.value - maxPageNumbersToShow + 1;
      endPage = pageCount.value;
    } else {
      // Средние страницы
      startPage = props.currentPage - maxPagesBeforeCurrentPage;
      endPage = props.currentPage + maxPagesAfterCurrentPage;
    }
  }
  for (let i = startPage; i <= endPage; i++) {
    pages.push(i);
  }
  return pages;
});

const showInitialEllipsis = computed(() => pageNumbersToShow.value[0] > 1);
const showFinalEllipsis = computed(() => pageNumbersToShow.value[pageNumbersToShow.value.length - 1] < pageCount.value);

const setCurrentPage = (newPage) => {
  if (newPage >= 1 && newPage <= pageCount.value) {
    emit('update:currentPage', newPage);
  }
};
</script>

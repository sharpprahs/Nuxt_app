<template>
 <div class="user_container">
<div class="container_nav_panel_adaptation mr">
  <button class="container_nav_panel__show mr" @click="show_menu_mobile_params"><span>{{title_button}}</span></button>
<!--сюда кнопку на мобилку-->
  <div class="container_nav_panel">
    <div class="container_nav_panel_content">
  <h1 class="general_title mr">
    <span class="msb">Linvistics</span> <br>Панель Администратора
  </h1>
    <div class="selects_lang_answer_and_task">
     <div class="selects_lang_answer_and_task__block mr">
      <div>Язык заданий</div>
       <multiselect
           v-model="selectedOption_task"
           :options="options_language"
           :multiple="false"
           :close-on-select="true"
           :clear-on-select="false"
           placeholder="Выберите язык"
           :allow-empty="false"
           label="name"
           track-by="code"
           :select-label="'Enter для выбора'"
           :selected-label="'Выбрано'"
           :deselect-label="'Нажмите, чтобы удалить'"
           :no-options-label="'Нет элементов'"
       > <template #noResult>Такого языка нету</template>
       </multiselect>
     </div>
      <div class="selects_lang_answer_and_task__block mr">
        <div>Язык ответа</div>
        <multiselect
            v-model="selectedOption_answer"
            :options="options_language"
            :multiple="false"
            :close-on-select="true"
            :clear-on-select="false"
            placeholder="Выберите язык"
            :allow-empty="false"
            label="name"
            track-by="code"
            :select-label="'Нажмите Enter, чтобы выбрать'"
            :selected-label="'Выбрано'"
            :deselect-label="'Нажмите, чтобы удалить'"
            :no-options-label="'Нет элементов'"
        > <template #noResult>Такого языка нету</template>
        </multiselect>
      </div>
    </div>
    <div class="search_task_theme mr">
<h2 class="mr" id="theme_tasks">Темы</h2>
      <button class="add_theme mr"><span>Добавить тему</span></button>
      <input type="text" class="search_content mr" placeholder="Найти" aria-labelledby="theme_tasks">
      <button class="button_search_content mm">Найти</button>
    </div>
    <nav class="theme_tasks_navigation">
<ul>
  <li><h3><a class="_active">Present simple</a></h3></li>
  <li><h3><a>Model language</a></h3></li>
  <li><h3><a>Model language</a></h3></li>
  <li><h3><a>Model language</a></h3></li>
</ul>
    </nav>
<!-- paginate_this-->
    <div class="pagination_container">
      <Paginate
          :total-elements="totalElements"
          :amount-on-page="amountOnPage"
          :current-page="currentPage"
          :last-value=false
          :first-value=false
          @update:currentPage="setCurrentPage"
      />
    </div>
</div>
  </div>
</div>
   <div class="container_tasks mr">
     <div class="container_tasks__theme _admin_panel">
       <h4 class="msb">
         Present simple
       </h4>
       <div class="container_amount_task_answer">
<div>
  Всего заданий<span class="amount_task mm">8</span>
</div>
       </div>
       <div class="container_task">
         <div class="container_task__status">
           <h5 class="mr">1 Задание</h5>
           <div class="panel_buttons_task">
             <button class="save_changes_task mr">Сохранить</button>
             <button class="delete_task mr">Удалить</button>
           </div>
         </div>
         <div class="choice_content_task_panel">
           <multiselect
               class="choice_task_select"
               v-model="selectedOption_item_task"
               :options="options_task_item"
               :multiple="false"
               :close-on-select="true"
               :clear-on-select="false"
               placeholder="Выберите язык"
               :allow-empty="false"
               label="name"
               track-by="name"
               :select-label="'Enter для выбора'"
               :selected-label="'Выбрано'"
               :deselect-label="'Нажмите, чтобы удалить'"
               :no-options-label="'Нет элементов'"
           > <template #noResult>Такого языка нету</template>
           </multiselect>
           <div class="upload-btn-wrapper mr">
             <button class="btn mr" @click="triggerFileInput">Загрузить файл</button>
             <input type="file" ref="fileInput" class="upload_file" @change="handleFileUpload" />
             <!-- Отобразить имя файла, если оно есть -->
             <div v-if="fileName" class="file-name">{{ fileName }}</div>
           </div>
         </div>
         <img class="task_img" src="../../assets/images/tasks/images_webp/works.webp" alt="Картинка рабочего правильный ответ work">
      <div class="choice_content_task_panel">
        <div class="task_description_title">Описание</div>
      </div>
         <textarea type="text" class="this_task_description _for_description mr">Нажмите на запись и скажите что вы видите на картинке</textarea>
         <div class="choice_content_task_panel">
           <div class="task_description_title">Правильный ответ</div>
         </div>
         <textarea type="text" class="this_task_description _for_true_answer mr">Работа</textarea>
         <button class="add_task mr"><span>Добавить задание</span></button>

       </div>
       </div>
       </div>
   </div>

<!--  <ul>-->
<!--    <li v-for="bank in product" :key="bank.id">-->
<!--      <h2>{{ bank.title }}</h2>-->
<!--      <pre>{{ bank.text}}</pre>-->
<!--    </li>-->
<!--  </ul>-->
</template>

<script setup>
import {computed, ref } from 'vue';
import Multiselect from "vue-multiselect";
import Paginate from "@/components/Pagination.vue"
import "@/assets/css/MyPagination.css";
import "@/assets/css/vue-multiselect.css";

const fileInput = ref(null);
const fileName = ref(''); // Реактивная переменная для имени файла

const triggerFileInput = () => {
  fileInput.value.click();
};

const handleFileUpload = (event) => {
  const files = event.target.files;
  if (files.length > 0) {
    fileName.value = files[0].name; // Сохраняем имя файла
  }
// Устанавливаем таймер для очистки имени файла через 4 секунды
  setTimeout(() => {
    fileName.value = '';
  }, 4000);
  // Дополнительная обработка файлов здесь
};


const totalElements = ref(100); // общее количество элементов
const amountOnPage = ref(10); // количество элементов на странице
const currentPage = ref(1); // текущая страница
// const allItems = ref([]); // массив элементов

const paginatedItems = computed(() => {
  // Ваш код для определения элементов текущей страницы
});

// Функция обновления текущей страницы
const setCurrentPage = (newPage) => {
  currentPage.value = newPage;
};


// Создаем реактивную переменную для выбранного значения
const selectedOption_task = ref({ name: 'Английский', code: 'en' });
const selectedOption_item_task = ref({ name: 'Картинка'});
const selectedOption_answer = ref({ name: 'Русский', code: 'ru' });
const page = ref(10);


// Определяем опции для выбора
const options_language = [
  { name: 'Английский', code: 'en' },
  { name: 'Русский', code: 'ru' },
  // ...добавьте другие языки
];

const options_task_item = [
  { name: 'Картинка' },
  { name: 'Видео' },
  { name: 'Аудио' },
  // ...добавьте другие языки
];


const title_button = ref('Панель Администратора');
function show_menu_mobile_params() {
  document.querySelector('.container_nav_panel').classList.toggle('_active');
  document.querySelector('.container_nav_panel__show').classList.toggle('_active');
  title_button.value = title_button.value === 'Скрыть панель' ? 'Панель Администратора' : 'Скрыть панель';
}
// const id = ref(1)
// const { data: product, error } = await useFetch(() => `https://localhost:8000/api/posts`)

</script>

<style scoped>
</style>

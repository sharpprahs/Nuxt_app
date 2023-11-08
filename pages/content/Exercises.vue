<template>
 <div class="user_container">
<div class="container_nav_panel_adaptation mr">
  <button class="container_nav_panel__show mr" @click="show_menu_mobile_params"><span>{{title_button}}</span></button>
<!--сюда кнопку на мобилку-->
  <div class="container_nav_panel">
    <div class="container_nav_panel_content">
  <h1 class="general_title mm">
    <span class="msb">Linvistics</span> <br>Параметры тренажёра
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
            :select-label="'Enter для выбора'"
            :selected-label="'Выбрано'"
            :deselect-label="'Нажмите, чтобы удалить'"
            :no-options-label="'Нет элементов'"
        > <template #noResult>Такого языка нету</template>
        </multiselect>
      </div>
    </div>
    <div class="search_task_theme mr">
<h2 class="mr" id="theme_tasks">Темы</h2>
      <input type="text" class="search_content mr" placeholder="Найти" aria-labelledby="theme_tasks">
      <button class="button_search_content mm">Найти</button>
    </div>
    <nav class="theme_tasks_navigation">
<ul>
  <li v-for="topic in topics" :key="topic.name"><h3><a :class="{'_active': topic.isActive === true}">{{ topic.name}}</a></h3></li>
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
     <div class="container_tasks__theme">
       <h4 class="msb">
         Present simple
       </h4>
       <div class="container_amount_task_answer">
<div>
  Всего заданий<span class="amount_task mm">1</span>
</div>
         <div>
           Ответы<span class="true_answer mm">{{ true_answer }}</span> / <span class="false_answer mm">0</span>
         </div>
       </div>
       <div class="container_task">
       <h5 class="mr">1 Задание</h5>
         <img class="task_img" src="../../assets/images/tasks/images_webp/works.webp" alt="Картинка рабочего правильный ответ work">
      <p class="task_description">Нажмите на запись и скажите что вы видите на картинке</p>
         <div class="container_recording">
           <button :class="{ 'start_recording': !isRecording, 'stop_recording': isRecording }" @click="toggleRecording"></button>
           <div :class="{ 'line_voice': !isRecording, 'line_voice_record': isRecording }" ></div>
         </div>
         <div v-if="audioUrl" class="play_send_container">
           <button @click="playAudio" class="play_audio mr"><span>Произвести аудио</span></button>
           <button @click="sendAudio" class="send_answer mr">Ответить</button>
         </div>
         <div class="answer_static_container" v-if="last_question">
           <div class="percentage_of_correct_answers">Правильных ответов <span class="mm">100%</span></div>
           <div class="un_correct_correct_answers">
             Ответы<span class="true_answer mm">{{ true_answer }}</span> / <span class="false_answer mm">0</span>
           </div>
         </div>
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
import {computed, ref, reactive, onMounted } from 'vue';
import Multiselect from "vue-multiselect";
import Paginate from "@/components/Pagination.vue"
import "@/assets/css/MyPagination.css";
import "@/assets/css/vue-multiselect.css";

const isRecording = ref(false);
const audioChunks = ref([]);
const mediaRecorder = ref(null);
const audioUrl = ref('');
const true_answer = ref(0);
const last_question = ref(false);

const toggleRecording = () => {
  if (isRecording.value) {
    mediaRecorder.value.stop();
    isRecording.value = false;
  } else {
    audioChunks.value = [];
    mediaRecorder.value.start();
    isRecording.value = true;
  }
};

const playAudio = () => {
  const audio = new Audio(audioUrl.value);
  audio.play();
};

const sendAudio = async () => {
  last_question.value = true;
  true_answer.value++;
};

onMounted(async () => {
  try {
    const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
    mediaRecorder.value = new MediaRecorder(stream);
    mediaRecorder.value.ondataavailable = (event) => {
      audioChunks.value.push(event.data);
    };
    mediaRecorder.value.onstop = () => {
      const audioBlob = new Blob(audioChunks.value, { type: 'audio/wav' });
      audioUrl.value = URL.createObjectURL(audioBlob);
    };
  } catch (e) {
    console.error('Ошибка при инициализации MediaRecorder:', e);
  }
});


//Список тем
const topics = reactive([
  { name: 'Тема 1', isActive: true },
  { name: 'Тема 2', isActive: false },
  { name: 'Тема 3', isActive: false },
  { name: 'Тема 4', isActive: false },
  // другие темы
]);
// Функция для переключения состояния активности темы
const toggleTopicActive = (topic) => {
  topic.isActive = !topic.isActive;
};

//Пагинация
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
const selectedOption_task = ref({ name: 'English', code: 'en' });
const selectedOption_answer = ref({ name: 'Русский', code: 'ru' });
const page = ref(10);


// Определяем опции для выбора
const options_language = [
  { name: 'English', code: 'en' },
  { name: 'Русский', code: 'ru' },
  // ...добавьте другие языки
];

//Мобильная версия кнопки которая открывает меню
const title_button = ref('Параметры тренажёра');
function show_menu_mobile_params() {
  document.querySelector('.container_nav_panel').classList.toggle('_active');
  document.querySelector('.container_nav_panel__show').classList.toggle('_active');
  title_button.value = title_button.value === 'Скрыть параметры' ? 'Параметры тренажёра' : 'Скрыть параметры';
}
// const id = ref(1)
// const { data: product, error } = await useFetch(() => `https://localhost:8000/api/posts`)

</script>

<style scoped>
</style>

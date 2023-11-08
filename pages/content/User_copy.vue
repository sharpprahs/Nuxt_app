<template>
 <div class="user_container">
<div class="container_nav_panel_adaptation mr">
<!--сюда кнопку на мобилку-->
  <div class="container_nav_panel">
  <h1 class="mm">
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
           :select-label="'Нажмите Enter, чтобы выбрать'"
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
   <div class="container_tasks mr">
     <div class="container_tasks__theme">
       <h4 class="msb">
         Present simple
       </h4>
       <div class="container_amount_task_answer">
<div>
  Всего заданий<span class="amount_task mm">8</span>
</div>
         <div>
           Ответы<span class="true_answer mm">0</span> / <span class="false_answer mm">0</span>
         </div>
       </div>
       <div class="container_task">
       <h5 class="mr">1 Задание</h5>
         <img class="task_img" src="../../assets/images/tasks/images_webp/works.webp" alt="Картинка рабочего правильный ответ work">
      <p class="task_description">Нажмите на запись и скажите что вы видите на картинке</p>
         <div>
           <div ref="waveformContainer" class="waveform"></div>
           <button @click="startRecording">Start Recording</button>
           <button @click="stopRecording" :disabled="!isRecording">Stop Recording</button>
           <button @click="playAudio" :disabled="!audioUrl">Play</button>
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
import {computed, ref, onMounted, onBeforeUnmount, reactive} from 'vue';
import Multiselect from "vue-multiselect";
import WaveSurfer from 'wavesurfer.js';
import Paginate from "@/components/Pagination.vue"
import "@/assets/css/MyPagination.css";
import "@/assets/css/vue-multiselect.css";

const waveformContainer = ref(null);
const wavesurfer = ref(null);
const isRecording = ref(false);
const audioUrl = ref(null);
let mediaRecorder = null;
let audioChunks = [];

onMounted(() => {
  wavesurfer.value = WaveSurfer.create({
    container: waveformContainer.value,
    waveColor: 'violet',
    progressColor: 'purple',
    cursorColor: 'navy',
    height: 100,
    responsive: true,
  });

  // Navigator.getUserMedia is deprecated, use navigator.mediaDevices.getUserMedia
  navigator.mediaDevices.getUserMedia({ audio: true }).then(stream => {
    mediaRecorder = new MediaRecorder(stream);
    mediaRecorder.ondataavailable = event => {
      audioChunks.push(event.data);
    };
    mediaRecorder.onstop = () => {
      const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
      audioUrl.value = URL.createObjectURL(audioBlob);
      wavesurfer.value.load(audioUrl.value);
      audioChunks = []; // Clear the chunks for the next recording
    };
  }).catch(e => console.error('Error getting audio stream:', e));
});

onBeforeUnmount(() => {
  wavesurfer.value.destroy();
  wavesurfer.value = null;
});

const startRecording = () => {
  if (!mediaRecorder) return;

  audioUrl.value = null; // Reset the audio URL
  isRecording.value = true;
  audioChunks = []; // Clear any previous recorded chunks
  mediaRecorder.start();

  if (wavesurfer.value.backend && wavesurfer.value.backend.audioContext) {
    wavesurfer.value.backend.audioContext.resume().then(() => {
      console.log('AudioContext resumed successfully.');
    }).catch(e => console.error('Error resuming audio context:', e));
  } else {
    console.error('The audio context or its AudioContext object is not available.');
  }
};

const stopRecording = () => {
  if (!mediaRecorder || !isRecording.value) return;

  isRecording.value = false;
  mediaRecorder.stop();
  // It's not necessary to close the AudioContext as we might want to use it again
};

const playAudio = () => {
  if (audioUrl.value) {
    wavesurfer.value.playPause();
  }
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
const selectedOption_answer = ref({ name: 'Русский', code: 'ru' });
const page = ref(10);


// Определяем опции для выбора
const options_language = [
  { name: 'Английский', code: 'en' },
  { name: 'Русский', code: 'ru' },
  // ...добавьте другие языки
];

// const id = ref(1)
// const { data: product, error } = await useFetch(() => `https://localhost:8000/api/posts`)

</script>

<style scoped>
</style>

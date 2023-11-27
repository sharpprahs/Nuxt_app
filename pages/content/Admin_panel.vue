<template>
 <div class="admin_container">
<div class="container_nav_panel_adaptation_admin mr">
  <button class="container_nav_panel__show_admin mr" @click="show_menu_mobile_params"><span>{{title_button}}</span></button>
<!--сюда кнопку на мобилку-->
  <div class="container_nav_panel_admin">
    <div class="container_nav_panel_content_admin">
  <h1 class="general_title mr">
    <span class="msb">Админ панель</span>
  </h1>
    <div class="selects_lang_answer_and_task_admin">
     <div class="selects_lang_answer_and_task__block_admin mr">
      <div>Язык заданий</div>
       <multiselect
           v-model="active_params_task.task_lang_active"
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
      <div class="selects_lang_answer_and_task__block_admin mr">
        <div>Язык ответа</div>
        <multiselect
            v-model="active_params_task.answer_lang_active"
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
            class="_rss"
        > <template #noResult>Такого языка нету</template>
        </multiselect>
        <button class="add_theme_sections_admin" @click="() => openPopup('is_visible_edit_languages')">{{ popup_state.edit_languages }}</button>
      </div>
      <UIPopup   :show="popup_state.is_visible_edit_languages"
                 :title_popup="popup_state.edit_languages"
                 @close="() => closePopup('is_visible_edit_languages')"
      >
        <div class="popup_panel_container">
          <div class="mm popup_panel_container__title mcb">Удаление языка</div>
          <div class="languages_edit" v-for="lang in options_language" key="lang.code">
          <span>{{ lang.name}}</span>
            <button @click="delete_language(lang.id)">Удалить</button>
          </div>
          <div class="popup_panel_container__input">
            <div class="mm popup_panel_container__title mc">Добавление языка</div>
            <label for="name_section">code языка <span class="mc">ENG</span></label>
            <input type="text" v-model="code_lang_add" placeholder="Введите код" aria-labelledby="name_section" id="name_section">
          </div>
          <div class="popup_panel_container__input">
            <label for="title_section">Название языка</label>
            <input type="text" v-model="name_lang_add" placeholder="Введите название" aria-labelledby="title_section" id="title_section">
          </div>
          <span ref="messageElement" class="message_add_lang" v-if="message_add_lang != null">{{message_add_lang}}</span>
          <UIButton @click="addLanguage">Добавить язык</UIButton>
        </div>
      </UIPopup>
    </div>
      <div class="theme_sections_admin mr">
        <h2 class="mr" id="theme_tasks">Разделы</h2>
        <transition-group name="fall" tag="div" class="section_container_all">
        <button class="theme_sections" v-for="section in all_sections" :key="section.code" @click="active_section(section)"  :class="{ '_active': active_params_task.section_active?.code === section.code }">{{section.name}}</button>
        </transition-group>
          <button class="add_theme_sections_admin mr" @click="() => openPopup('is_visible_theme_sections')"><span>{{ popup_state.theme_sections_title }}</span></button>
      </div>
<UIPopup   :show="popup_state.is_visible_theme_sections"
           :title_popup="popup_state.theme_sections_title"
           @close="() => closePopup('is_visible_theme_sections')"
>
<div class="popup_panel_container">
  <div class="mm popup_panel_container__title mcb">Удаление раздела</div>
  <div class="languages_edit" v-for="section in all_sections" key="section.code">
    <span>{{ section.name}}</span>
    <button @click="delete_section(section.id)">Удалить</button>
  </div>
  <div class="popup_panel_container__input">
    <label for="name_section">Сокращённая абреввиатура раздела <span class="mc">ENG</span></label>
    <input type="text" v-model="code_section_add"  placeholder="Введите абреввиатуру" aria-labelledby="name_section" id="name_section">
  </div>
  <div class="popup_panel_container__input">
    <label for="title_section">Название раздела</label>
    <input type="text" v-model="name_section_add"  placeholder="Введите название" aria-labelledby="title_section" id="title_section">
  </div>
  <span ref="messageElement_section" class="message_add_lang" v-if="message_add_section != null">{{message_add_section}}</span>
  <UIButton @click="addSection">Добавить раздел</UIButton>
</div>
</UIPopup>
    <div class="search_task_theme_admin mr">
      <UIPopup   :show="popup_state.is_visible_add_theme"
                 :title_popup="popup_state.add_theme"
                 @close="() => closePopup('is_visible_add_theme')"
      >
        <div class="popup_panel_container">
          <div class="popup_panel_container__input">
            <label for="name_section">Сокращённая абреввиатура раздела <span class="mc">ENG</span></label>
            <input type="text" placeholder="Введите абреввиатуру" aria-labelledby="name_section" id="name_section">
          </div>
          <div class="popup_panel_container__input">
            <label for="title_section">Название раздела</label>
            <input type="text" placeholder="Введите название" aria-labelledby="title_section" id="title_section">
          </div>
          <UIButton>Добавить раздел</UIButton>
        </div>
      </UIPopup>
<h2 class="mr" id="theme_tasks">Темы</h2>
    </div>
<div class="wait_panda_container" v-if="active_params_task.answer_lang_active == null || active_params_task.task_lang_active == null || active_params_task.section_active == null">
<span ref="textElement" class="mm"></span>
  <img src="../../assets/images/gif/wait_panda.gif" alt="Жду выбора раздела,языка заданий, языка вопросов">
</div>
      <div class="theme_all_section" v-if="active_params_task.answer_lang_active !=null && active_params_task.task_lang_active != null && active_params_task.section_active != null">
      <button class="add_theme_admin mr" @click="() => openPopup('is_visible_add_theme')"><span>{{ popup_state.add_theme}}</span></button>
      <input type="text" class="search_content_admin mr" placeholder="Найти" aria-labelledby="theme_tasks">
      <button class="button_search_content_admin mm">Найти</button>
    <nav class="theme_tasks_navigation_admin">
<ul>
  <transition-group name="fall" tag="ul">
  <li v-for="item in theme_items" :key="item.id" @click="download_active_theme(item.name)" :class="{ '_active': active_params_task.theme_active === item.name }"><h3><a>{{ item.name}}</a></h3></li>
  </transition-group>
</ul>
    </nav>
<!-- paginate_this-->
    <div class="pagination_container_admin">
      <Paginate
          v-if="totalElements > 8"
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
</div>
   <div class="container_tasks_admin mr">

<div class="before_loading_theme_container mr">
  <div class="loading_status_text" v-if="active_params_task.theme_active == null">В Панели Администратора выберите <div class="loading_status_text_spans"><span class="mc_v2" v-if="active_params_task.task_lang_active == null">ㅤЯзык заданийㅤ</span><span class="mcr" v-if="active_params_task.answer_lang_active == null">ㅤЯзык ответаㅤ</span><span class="mcf" v-if="active_params_task.section_active == null">ㅤРазделㅤ</span><span class="mcb" v-if="active_params_task.theme_active == null">ㅤТемуㅤ</span></div></div>
<div class="task_theme_active_container" v-if="active_params_task.theme_active != null">
  <h4 class="msb task_theme_active_title">Present simple</h4>
<div class="task_theme_active_container__params">
  <div class="amount_task_container mr">
    <div>Всего заданий</div><span class="amount_task mm">8</span>
  </div>
  <button class="mr"><span>Удалить тему</span></button>
</div>

</div>

  <!--  <h4 class="task_theme_title_container">-->
<!--    <img src="../../assets/images/svg/delete_task.svg" alt="Удалить текущую тему">-->
<!--    Present simple-->
<!--  </h4>-->
<!--  <div>-->
<!--    Всего заданий<span class="amount_task mm">8</span>-->
<!--  </div>-->
 <div class="image_status_loading__container">
<div class="image_status_loading_pillar mm">
  <div class="task_params_active_status _lang_a">
{{ active_params_task.task_lang_active?.code}}
  </div>
  <div class="task_params_active_status _section">
    {{ active_params_task.answer_lang_active?.code }}
  </div>
  <div class="task_params_active_status _lang_t">
 {{ active_params_task.section_active?.code }}
  </div>

</div>
 </div>
</div>


     <div class="container_tasks__theme_admin" v-if="active_params_task.theme_active != null">
       <div class="container_amount_task_answer_admin">
       </div>
       <div class="container_task_admin">
         <div class="container_task__status_admin">
           <h5 class="mr h5_titles">1 Задание</h5>
         </div>
         <div class="content_container_admin">
         <div class="choice_content_task_panel_admin">
           <multiselect
               class="choice_task_select_admin"
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
           <div class="upload-btn-wrapper_admin mr">
             <button class="btn mr" @click="triggerFileInput">Загрузить файл</button>
             <input type="file" ref="fileInput" class="upload_file" @change="handleFileUpload" />
             <!-- Отобразить имя файла, если оно есть -->
             <div v-if="fileName" class="file-name">{{ fileName }}</div>
           </div>
         </div>
         <img class="task_img_admin" src="../../assets/images/tasks/images_webp/works.webp" alt="Картинка рабочего правильный ответ work">
         </div>
         <div class="content_container_admin">
      <div class="choice_content_task_panel_admin">
        <div class="task_description_title_admin">Описание</div>
      </div>
         <textarea type="text" class="this_task_description_admin _for_description mr">Нажмите на запись и скажите что вы видите на картинке</textarea>
         </div>
         <div class="content_container_admin">
           <div class="choice_content_task_panel_admin">
           <div class="task_description_title">Правильный ответ</div>
         </div>
         <textarea type="text" class="this_task_description_admin _for_true_answer mr">Работа</textarea>
           <div class="container_buttons_task">
             <button class="do_it_button mc_bg">Сохранить</button>
             <button class="do_it_button mcr">Удалить</button>
           </div>
           </div>
       </div>
       <button class="do_it_button_add_task mr"><span>Добавить задание</span></button>
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
import {computed, ref, reactive,nextTick, watch, onMounted} from 'vue';
import Multiselect from "vue-multiselect";
import Paginate from "@/components/Pagination.vue"
import axios from "axios";
import "@/assets/css/MyPagination.css";
import "@/assets/css/vue-multiselect.css";
definePageMeta({
  middleware: 'auth'
});


// popup
let popup_state = reactive({
  is_visible_theme_sections: false,
  theme_sections_title: 'Редактировать разделы',
  edit_languages: 'Редактировать языки',
  is_visible_edit_languages: false,
  add_theme: 'Добавить тему',
  is_visible_add_theme: false,
});

function closePopup(propKey) {
  console.log(propKey);
  if (popup_state[propKey] !== undefined) {
    popup_state[propKey] = false;
    document.body.style.overflow = "auto";
  }
}
function openPopup(propKey) {
  if (popup_state[propKey] !== undefined) {
    popup_state[propKey] = true;
    document.body.style.overflow = "hidden";
  }
}

// popup_end

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


const totalElements = ref(0); // общее количество элементов
const amountOnPage = ref(8); // количество элементов на странице
const currentPage = ref(1); // текущая страница
const theme_items = ref([]);

const active_params_task = reactive({
  task_lang_active: null,
  answer_lang_active: null,
  section_active: null,
  theme_active : null,
});

// Метод для получения данных о темах
const fetchThemes = async (page) => {
  try {
    const token = localStorage.getItem('token');
    const response = await axios.get('http://localhost:8000/api/exercises', {
      headers: {
        'Authorization': `Bearer ${token}`
      },
      params: {
        page: page,
        id_lang_task: active_params_task.task_lang_active,
        id_lang_answer: active_params_task.answer_lang_active,
        id_section: active_params_task.section_active,
        // Дополнительные параметры фильтрации могут быть добавлены здесь
      }
    });

    theme_items.value = response.data.themes; // Обновление списка тем
    totalElements.value = response.data.total; // Обновление общего количества элементов
    currentPage.value = response.data.currentPage; // Обновление текущей страницы
  } catch (error) {
    console.error('Ошибка при получении тем:', error);
    // Обработка ошибок
  }
};


//Печать текста
const textElement = ref(null);
const duration_first = 7000;
const duration_last = 400;
let charIndex = 0;
let isTyping = true;
let typingTimeout = null;

function getCurrentText() {
  let textToType = "Разбуди когда выберешь -";
  if (active_params_task.task_lang_active === null) textToType += " язык заданий";
  if (active_params_task.answer_lang_active === null) textToType += (textToType === "Разбуди когда выберешь -" ? " язык ответа" : ", язык ответа");
  if (active_params_task.section_active === null) textToType += (textToType === "Разбуди когда выберешь -" ? " раздел" : ", раздел");
  return textToType;
}

function startNewText() {
  clearTimeout(typingTimeout);
  charIndex = 0;
  isTyping = true;
  textElement.value.textContent = '';
  typeAndEraseText();
}

function typeAndEraseText() {
  // Проверка на существование элемента
  if (!textElement.value) return;

  const currentText = getCurrentText();
  if (!currentText) return;

  if (isTyping) {
    if (charIndex < currentText.length) {
      textElement.value.textContent += currentText.charAt(charIndex);
      charIndex++;
      typingTimeout = setTimeout(typeAndEraseText, 100);
    } else {
      isTyping = false;
      typingTimeout = setTimeout(typeAndEraseText, duration_first);
    }
  } else {
    if (charIndex > 0) {
      charIndex--;
      textElement.value.textContent = currentText.substring(0, charIndex);
      typingTimeout = setTimeout(typeAndEraseText, 100);
    } else {
      isTyping = true;
      typingTimeout = setTimeout(startNewText, duration_last);
    }
  }
}
//Печать текста конец
// Вотчер, который следит за изменениями переменных и вызывает fetchThemes
watch(
    () => [
      active_params_task.task_lang_active,
      active_params_task.answer_lang_active,
      active_params_task.section_active
    ],
    (newValues, oldValues) => {
      // Проверяем, что все переменные не null
      const allNotNull = newValues.every(value => value !== null);
      if (allNotNull) {
        fetchThemes(currentPage.value);
        active_params_task.theme_active = null;
      } else{
        startNewText();
      }
    }
);

onMounted(() => {
  startNewText();
});
// const allItems = ref([]); // массив элементов

// const paginatedItems = computed(() => {
//   // код для определения элементов текущей страницы
// });

// Функция обновления текущей страницы
const setCurrentPage = (newPage) => {
  currentPage.value = newPage;
  fetchThemes(newPage);
};


// Создаем реактивную переменную для выбранного значения
const selectedOption_task = ref([]);
const selectedOption_item_task = ref({ name: 'Картинка'});
const selectedOption_answer = ref([]);
const page = ref(10);

//рендер Языков
const fetchLanguages = async () => {
  try {
    const token = localStorage.getItem('token');
    const response = await axios.get('http://localhost:8000/api/all_languages', {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    });
    return response.data;
  } catch (error) {
    console.error('Ошибка при получении данных о языках:', error);
    return [];
  }
};
const options_language = ref([]);
onMounted(async () => {
 options_language.value = await fetchLanguages();
});
//рендер Языков конец

//Добавление языка
const code_lang_add = ref(null);
const name_lang_add = ref(null);
const messageElement = ref(null);
const message_add_lang = ref(null);

const updateMessage = async (message, addClass,color) => {
  message_add_lang.value = message;
  if (addClass) {
    await nextTick();
    messageElement.value.classList.add(color);
    setTimeout(() => {
      messageElement.value.classList.remove(color);
      message_add_lang.value = null;
    }, 3000);
  }
};
const addLanguage = async () => {
  if (!code_lang_add.value || !name_lang_add.value) {
    updateMessage('Все поля должны быть заполнены', true, 'mcb');
    return;
  }
  try {
    const token = localStorage.getItem('token');
    const response = await axios.post('http://localhost:8000/api/languages_add', {
      code: code_lang_add.value,
      name: name_lang_add.value
    }, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    });
    // Добавление нового языка в список языков
    options_language.value.push(response.data);
    updateMessage('Язык успешно добавлен', true,'mc');

    console.log('Язык добавлен:', response.data);
    // Очистить поля после добавления
    code_lang_add.value = null;
    name_lang_add.value = null;
  } catch (error) {
    updateMessage('CODE языка должен быть уникальным', true, 'mcb');
    console.error('Ошибка при добавлении языка:', error);
  }
};


// Удаление языка по id
const delete_language = async (id) => {
  try {
    const token = localStorage.getItem('token');
    await axios.delete(`http://localhost:8000/api/language_delete/${id}`, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    });
    // Обновление списка языков после удаления
    options_language.value = options_language.value.filter(lang => lang.id !== id);
    selectedOption_answer.value = null; //очищяем селекты
    selectedOption_task.value = null;
    console.log('Язык удален:', id);
  } catch (error) {
    console.error('Ошибка при удалении языка:', error);
  }
};
//Рендер Секций(разделов)
const fetchSections = async () => {
  try {
    const token = localStorage.getItem('token');
    const response = await axios.get('http://localhost:8000/api/all_sections', {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    });
    return response.data;
  } catch (error) {
    console.error('Ошибка при получении данных о языках:', error);
    return [];
  }
};
const all_sections = ref([]);
onMounted(async () => {
  all_sections.value = await fetchSections();
});
//рендер Секций(разделов) конец

// Удаление секции по id
const delete_section = async (id) => {
  try {
    const token = localStorage.getItem('token');
    await axios.delete(`http://localhost:8000/api/section_delete/${id}`, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    });
    // Обновление списка языков после удаления
    all_sections.value = all_sections.value.filter(section => section.id !== id);
    console.log('Секция удалена:', id);
  } catch (error) {
    console.error('Ошибка при удалении секции:', error);
  }
};
//Конец удаления секции по id

//Добавление секции(создание)

const code_section_add = ref(null);
const name_section_add = ref(null);
const message_add_section = ref(null);
const messageElement_section = ref(null);

const updateMessage_section = async (message, addClass,color) => {
  message_add_section.value = message;
  if (addClass) {
    await nextTick();
    messageElement_section.value.classList.add(color);
    setTimeout(() => {
      messageElement_section.value.classList.remove(color);
      message_add_section.value = null;
    }, 3000);
  }
};

const addSection = async () => {
  console.log("Код секции",code_section_add.value, "Имя секции",name_section_add.value)
  if (!code_section_add.value || !name_section_add.value) {
    await updateMessage_section('Все поля должны быть заполнены', true, 'mcb');
    return;
  }
  try {
    const token = localStorage.getItem('token');
    const response = await axios.post('http://localhost:8000/api/section_add', {
      code: code_section_add.value,
      name: name_section_add.value
    }, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    });
    // Добавление нового языка в список языков
    all_sections.value.push(response.data);
    await updateMessage_section('Раздел успешно добавлен', true,'mc');

    console.log('Язык добавлен:', response.data);
    // Очистить поля после добавления
    code_section_add.value = null;
    name_section_add.value = null;
  } catch (error) {
    await updateMessage_section('CODE раздела должен быть уникальным', true, 'mcb');
    console.error('Ошибка при добавлении языка:', error);
  }
};
//конец создания секции

//Активная тема
function download_active_theme(val){
  active_params_task.theme_active = val;
}
//Активная тема конец

function active_section(val){
 active_params_task.section_active = val;
}

const options_task_item = [
  { name: 'Картинка' },
  { name: 'Видео' },
  { name: 'Аудио' },
  // ...добавьте другие языки
];


const title_button = ref('Панель Администратора');
function show_menu_mobile_params() {
  document.querySelector('.container_nav_panel_admin').classList.toggle('_active');
  document.querySelector('.container_nav_panel__show_admin').classList.toggle('_active');
  title_button.value = title_button.value === 'Скрыть панель' ? 'Панель Администратора' : 'Скрыть панель';
}
// const id = ref(1)
// const { data: product, error } = await useFetch(() => `https://localhost:8000/api/posts`)
</script>

<style scoped>
</style>

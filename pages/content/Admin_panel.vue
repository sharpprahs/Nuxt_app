<template>
 <div class="admin_container">
<div class="container_nav_panel_adaptation_admin mr">
  <button class="container_nav_panel__show_admin mr" @click="show_menu_mobile_params"><span>{{title_button}}</span></button>
<!--сюда кнопку на мобилку-->
  <div class="container_nav_panel_admin">
    <h1 class="general_title mr">
      <span class="mr">Панель Администратора</span>
    </h1>
    <UIPopup   :show="popup_state.is_visible_edit_languages"
               :title_popup="popup_state.edit_languages"
               @close="() => closePopup('is_visible_edit_languages')"
    >
      <div class="popup_panel_container">
        <div class="mm popup_panel_container__title">Удаление языка</div>
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
    <div class="container_nav_panel_content_admin">
    <div class="selects_lang_answer_and_task_admin">
     <div class="selects_lang_answer_and_task__block_admin special_index_z mr">
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
        <button class="button_search_content mr atsa_pt" @click="() => openPopup('is_visible_edit_languages')">{{ popup_state.edit_languages }}</button>
      </div>
    </div>
      <div class="theme_sections_admin_container">
      <div class="theme_sections_admin mr">
        <h2 class="mr" id="theme_tasks">Разделы</h2>
        <transition-group name="fall" tag="div" class="section_container_all">
        <button class="theme_sections" v-for="section in all_sections" :key="section.code" @click="active_section(section)"  :class="{ '_active': active_params_task.section_active?.code === section.code }">{{section.name}}</button>
        </transition-group>
          <button class="button_search_content atsa_pt  mr" @click="() => openPopup('is_visible_theme_sections')">{{ popup_state.theme_sections_title }}</button>
      </div>
      </div>
<UIPopup   :show="popup_state.is_visible_theme_sections"
           :title_popup="popup_state.theme_sections_title"
           @close="() => closePopup('is_visible_theme_sections')"
>
<div class="popup_panel_container">
  <div class="mm popup_panel_container__title">Удаление раздела</div>
  <div class="languages_edit" v-for="section in all_sections" key="section.code">
    <span>{{ section.name}}</span>
    <button @click="delete_section(section.id)">Удалить</button>
  </div>
  <div class="popup_panel_container__input">
    <div class="mm popup_panel_container__title mc">Добавление раздела</div>
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

      <UIPopup   :show="popup_state.is_visible_add_theme"
                 :title_popup="popup_state.add_theme"
                 @close="() => closePopup('is_visible_add_theme')"
      >
        <div class="popup_panel_container">
          <div class="popup_panel_container__input">
            <div class="mm popup_panel_container__title mc">Добавление темы</div>
          </div>
          <div class="popup_panel_container__input">
            <label for="title_section">Название темы</label>
            <input type="text" v-model="theme_add_name" placeholder="Введите название" aria-labelledby="title_section" id="title_section">
          </div>
          <span ref="messageElement_them" class="message_theme_add" v-if="message_theme_add != null">{{message_theme_add}}</span>
          <UIButton @click="addTheme">Добавить тему</UIButton>
        </div>
      </UIPopup>
<div class="theme_container_section_container">
      <div class="theme_container_section">
<h2 class="mr" id="theme_tasks">Темы</h2>
<div class="wait_panda_container" v-if="active_params_task.answer_lang_active == null || active_params_task.task_lang_active == null || active_params_task.section_active == null">
<span ref="textElement" class="mm"></span>
  <img src="../../assets/images/gif/wait_panda.gif" alt="Жду выбора раздела,языка заданий, языка вопросов">
</div>
      <div class="theme_all_section" v-if="active_params_task.answer_lang_active !=null && active_params_task.task_lang_active != null && active_params_task.section_active != null">
      <button class="button_search_content mr" @click="() => openPopup('is_visible_add_theme')"><span>{{ popup_state.add_theme}}</span></button>
      <div class="input_container">
        <input type="text" class="search_content_admin mr" placeholder="Поиск" aria-labelledby="theme_tasks" v-model="search_theme">
      <button class="button_search_content_admin" @click="search_this_theme">
        <img src="../../assets/images/svg/search.svg" alt="Поиск темы">
      </button>
      </div>
    <nav class="theme_tasks_navigation_admin">
<ul>
  <transition-group name="fall" tag="ul">
  <li v-for="item in theme_items" :key="item.name" @click="download_active_theme(item.name)" :class="{ '_active': active_params_task.theme_active === item.name }"><h3><a>{{ item.name}}</a></h3></li>
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
  </div>
</div>
   <div class="container_tasks_admin mr">
<div class="before_loading_theme_container_general">
  <div class="alert_container" :class="style_alert" v-if="status_alert">
    <span>{{message_alert}}</span>
  </div>
<div class="before_loading_theme_container mr">
  <div class="loading_status_text" v-if="active_params_task.theme_active == null">В Панели Администратора выберите <div class="loading_status_text_spans"><span class="mc_v2" v-if="active_params_task.task_lang_active == null">ㅤЯзык заданийㅤ</span><span class="mcr" v-if="active_params_task.answer_lang_active == null">ㅤЯзык ответаㅤ</span><span class="mcf" v-if="active_params_task.section_active == null">ㅤРазделㅤ</span><span class="mcb" v-if="active_params_task.theme_active == null">ㅤТемуㅤ</span></div></div>
<div class="task_theme_active_container" v-if="active_params_task.theme_active != null">
  <h4 class="msb task_theme_active_title">{{active_params_task.theme_active}}</h4>
<div class="task_theme_active_container__params">
  <div class="amount_task_container mr">
    <div>Всего заданий</div><span class="amount_task mm">{{amount_task}}</span>
  </div>
</div>

</div>

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
  <div class="theme_del_add_container" v-if="active_params_task.theme_active != null">
  <div class="theme_del_add">
    <button class="panel_button" :class="status_click" @click="save_themes('mcob alert_info', 'Сохраните изменения каждого упражнения по отдельности')">
      <img src="../../assets/images/svg/save_item.svg" alt="Сохранить тему">
    </button>
    <button class="panel_button" :class="status_click"  @click="add_task()">
      <img src="../../assets/images/svg/add_item_v2.svg" alt="Добавить тему">
    </button>
    <button class="panel_button" :class="status_click" @click="delete_task()">
      <img src="../../assets/images/svg/item_delete.svg" alt="Удалить тему">
    </button>
  </div>
  </div>

</div>
<div class="container_tasks__theme_admin_container" v-for="item in tasks" :key="item.number_task" v-if="active_params_task.theme_active != null">
     <div class="container_tasks__theme_admin" >
<!--       <component :is="getComponent(item.type)" :item="item" @file-uploaded="updateContent" ></component>-->
       <div class="container_task_admin">
         <div class="container_task__status_admin">
           <h5 class="mr h5_titles">{{item.number_task}} Задание</h5>
         </div>
         <div class="content_container_admin special_index_z">
         <div class="choice_content_task_panel_admin">
           <multiselect
             class="choice_task_select_admin"
             v-model="item.type"
             :options="options_task_item"
             placeholder="Выберите тип"
             :select-label="'Enter для выбора'"
             :selected-label="'Выбрано'"
             :multiple="false"
             :close-on-select="true"
             :allow-empty="false"
             :clear-on-select="false"
         >
           <template #noResult>Такого типа нету</template>
         </multiselect>
           <div class="upload-btn-wrapper_admin mr">
<!--             <button class="btn mr" @click="triggerFileInput">Загрузить файл</button>-->
             <input type="file" ref="fileInput" class="upload_file" @change="handleFileUpload" />
             <!-- Отобразить имя файла, если оно есть -->
             <div v-if="fileName" class="file-name">{{ fileName }}</div>
           </div>
         </div>
           <component :is="getComponent(item.type)" :item="item" @file-uploaded="updateContent" ></component>
         </div>

         <div class="content_container_admin">
      <div class="choice_content_task_panel_admin">
        <div class="task_description_title_admin">Описание</div>
      </div>
         <textarea type="text" class="this_task_description_admin _for_description mr" v-model="item.description">{{item.description}}</textarea>
         </div>
         <div class="content_container_admin">
           <div class="choice_content_task_panel_admin">
           <div class="task_description_title">Правильный ответ</div>
         </div>
         <textarea type="text" class="this_task_description_admin mr" v-model="item.true_answer">{{item.true_answer}}</textarea>
           </div>
         <div class="content_container_admin">
           <div class="choice_content_task_panel_admin">
             <div class="task_description_title">Ключевые слова</div>
           </div>
<!--           <li v-for="(keyword, index) in splitKeywords(task.keywords)" :key="index">-->
<!--             <button class="answer_keywords_button del_keyword">{{ keyword }}</button>-->
<!--           </li>-->
           <ul class="answer_keywords">
             <li v-for="(keyword, index) in splitKeywords(item.true_keywords)" :key="index"> <button class="answer_keywords_button del_keyword" @click="removeKeyword(item, keyword)"></button>{{ keyword }}</li>
           </ul>
           <div class="input_container">
             <input type="text" class="search_content_admin mr" placeholder="Ключевое слово" v-model="item.tempKeyword" aria-labelledby="theme_tasks">
             <button class="answer_keywords_button add_keyword" @click="addKeyword(item)"></button>
           </div>
         </div>
         <div class="info_message" v-if="item.alert_message != null">{{item.alert_message}}</div>
         <div class="buttons_admin_actions">
           <button class="buttons_admin mc_bg" @click="saveData(item)">Сохранить изменения</button>
           <button class="buttons_admin mcr" @click="deleteThisTask(item.number_task)">Удалить задание</button>
         </div>
       </div>
       </div>
</div>
     <div class="loading_more_line" ref="loadingRef" v-show="active_params_task.theme_active != null"><span>Привет, я печенька загружатор, я занимаюсь подгрузкой заданий из бд</span></div>
     <button class="buttons_admin_add mcb" v-if="active_params_task.theme_active != null" @click="addExercise">Добавить задание</button>
       </div>
  </div>
</template>

<script setup>
import {ref, reactive,nextTick, watch, onMounted} from 'vue';
import { fetchCsrfToken } from '~/utils/utils.js';
import Multiselect from "vue-multiselect";
import Paginate from "@/components/Pagination.vue"
import axios from "axios";
import "@/assets/css/MyPagination.css";
import "@/assets/css/vue-multiselect.css";
import {getCookie} from "cookies-next";
import ImageUploadComponent from '@/components/ImageUpload.vue';
import VideoUploadComponent from '@/components/VideoUpload.vue';
import AudioUploadComponent from '@/components/AudioUpload.vue';
import { getBaseUrl } from "~/utils/getBaseUrl.js"

definePageMeta({
  middleware: 'auth'
});
//Загрузка контента в упражнениях
const getComponent = (type) => {
  switch (type) {
    case 'img':
      return ImageUploadComponent;
    case 'video':
      return VideoUploadComponent;
    case 'audio':
      return AudioUploadComponent;
    default:
      return null;
  }
};

const updateContent = (updatedItem) => {
  // Обновите содержимое задания здесь
};


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
  // console.log(propKey);
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
    await fetchCsrfToken();
    // Определение параметров запроса
    const params = {
      page: page,
      id_lang_task: active_params_task.task_lang_active,
      id_lang_answer: active_params_task.answer_lang_active,
      id_section: active_params_task.section_active,
      // Дополнительные параметры фильтрации могут быть добавлены здесь
    };
    const baseUrl = getBaseUrl();

    // Отправка GET запроса с использованием axios
    const response = await axios.get(`${baseUrl}:8000/api/exercises`, {
      withCredentials: true,
      headers: {
        'X-XSRF-TOKEN': decodeURIComponent(getCookie('XSRF-TOKEN')),
        'Accept': 'application/json, text/plain, */*',
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
      },
      params: params
    });

    // Обработка ответа
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
  if(textElement.value) {
    textElement.value.textContent = '';
  }
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

// Функция обновления текущей страницы
const setCurrentPage = (newPage) => {
  currentPage.value = newPage;
  fetchThemes(newPage);
};


// Создаем реактивную переменную для выбранного значения
const selectedOption_task = ref([]);
const selectedOption_answer = ref([]);
const page = ref(10);

//рендер Языков

const fetchLanguages = async () => {
  try {
    const baseUrl = getBaseUrl();
    // Отправляем запрос и сразу возвращаем ответ
    return await $fetch(`${baseUrl}:8000/api/all_languages`, {
      method: 'GET',
      credentials: 'include', // Включаем credentials для кросс-доменных запросов
    });
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
    await updateMessage('Все поля должны быть заполнены', true, 'mcfr');
    return;
  }
  try {
    // Получение CSRF токена
    await fetchCsrfToken();

    // Определение параметров запроса
    const data = {
      code: code_lang_add.value,
      name: name_lang_add.value
      // Дополнительные параметры фильтрации могут быть добавлены здесь
    };
    const baseUrl = getBaseUrl();
    // Отправка GET запроса с использованием axios
    const response = await axios.post(`${baseUrl}/api/languages_add`,data, {
      withCredentials: true,
      headers: {
        'X-XSRF-TOKEN': decodeURIComponent(getCookie('XSRF-TOKEN')),
        'Accept': 'application/json, text/plain, */*',
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
      }
    });
    // Добавление нового языка в список языков
    options_language.value.push(response.data);
    await updateMessage('Язык успешно добавлен', true, 'mc');

    console.log('Язык добавлен:', response.data);
    // Очистить поля после добавления
    code_lang_add.value = null;
    name_lang_add.value = null;
  } catch (error) {
    await updateMessage('CODE языка должен быть уникальным', true, 'mcfr');
    console.error('Ошибка при добавлении языка:', error);
  }
};


// Удаление языка по id
const delete_language = async (id) => {
  try {
    // Получение CSRF токена
    await fetchCsrfToken();
    const baseUrl = getBaseUrl();

    await axios.delete(`${baseUrl}:8000/api/language_delete/${id}`, {
      withCredentials: true,
      headers: {
        'X-XSRF-TOKEN': decodeURIComponent(getCookie('XSRF-TOKEN')),
        'Accept': 'application/json, text/plain, */*',
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
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
    const baseUrl = getBaseUrl();
    // Отправляем запрос и сразу возвращаем ответ
    return await $fetch(`${baseUrl}:8000/api/all_sections`, {
      method: 'GET',
      credentials: 'include', // Включаем credentials для кросс-доменных запросов
    });
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
    // Получение CSRF токена
    await fetchCsrfToken();
    const baseUrl = getBaseUrl();
    await axios.delete(`${baseUrl}:8000/api/section_delete/${id}`, {
      withCredentials: true,
      headers: {
        'X-XSRF-TOKEN': decodeURIComponent(getCookie('XSRF-TOKEN')),
        'Accept': 'application/json, text/plain, */*',
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
      }
    });
    // Обновление списка языков после удаления
    all_sections.value = all_sections.value.filter(section => section.id !== id);
    active_params_task.section_active = null;
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
    await updateMessage_section('Все поля должны быть заполнены', true, 'mcfr');
    return;
  }
  try {
    // Получение CSRF токена
    await fetchCsrfToken();

    const data = {
        code: code_section_add.value,
        name: name_section_add.value
        // Дополнительные параметры фильтрации могут быть добавлены здесь
      };
    const baseUrl = getBaseUrl();
    const response = await axios.post(`${baseUrl}:8000/api/section_add`,data, {
      withCredentials: true,
        headers: {
          'X-XSRF-TOKEN': decodeURIComponent(getCookie('XSRF-TOKEN')),
          'Accept': 'application/json, text/plain, */*',
          'Content-Type': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
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
    await updateMessage_section('CODE раздела должен быть уникальным', true, 'mcfr');
    console.error('Ошибка при добавлении языка:', error);
  }
};
//конец создания секции

// Добавление темы
const theme_add_name = ref(null);
const message_theme_add = ref(null);
const messageElement_them = ref(null);

const updateMessage_theme = async (message, addClass,color) => {
  message_theme_add.value = message;
  if (addClass) {
    await nextTick();
    messageElement_them.value.classList.add(color);
    setTimeout(() => {
      messageElement_them.value.classList.remove(color);
      message_theme_add.value = null;
    }, 3000);
  }
};
const addTheme = async () => {
  if (!theme_add_name.value) {
    await updateMessage_theme('Все поля должны быть заполнены', true, 'mcfr');
    return;
  }
  try {
    // Получение CSRF токена
    await fetchCsrfToken();

    // Определение параметров запроса
    const data_themes = {
      id_lang_task: active_params_task.task_lang_active?.id,
      id_lang_answer: active_params_task.answer_lang_active?.id,
      id_section: active_params_task.section_active?.id,
      name: theme_add_name.value,
      // Дополнительные параметры фильтрации могут быть добавлены здесь
    };
    const baseUrl = getBaseUrl();
    // Отправка GET запроса с использованием axios
    const response = await axios.post(`${baseUrl}:8000/api/exercises_create`,data_themes, {
      withCredentials: true,
      headers: {
        'X-XSRF-TOKEN': decodeURIComponent(getCookie('XSRF-TOKEN')),
        'Accept': 'application/json, text/plain, */*',
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
      }
    });
    // Добавление нового языка в список языков
    await fetchThemes(1);
    await updateMessage_theme('Тема успешно добавлена', true, 'mc');

    console.log('Тема добавлена:', response.data);
    // Очистить поля после добавления
    theme_add_name.value = null;
  } catch (error) {
    await updateMessage_theme('name темы должен быть уникальным', true, 'mcfr');
    console.error('Ошибка при добавлении языка:', error);
  }
};
// Конец добавления темы

//Поиск темы
const search_theme = ref(null);
// search_this_theme
const search_this_theme = async () => {
  try {
    // Получение CSRF токена
    await fetchCsrfToken();

    // Определение параметров запроса
    const searchParams = {
      id_lang_task: active_params_task.task_lang_active?.id,
      id_lang_answer: active_params_task.answer_lang_active?.id,
      id_section: active_params_task.section_active?.id,
      name: search_theme.value,
    };

    // Отправка GET запроса с использованием axios
    const baseUrl = getBaseUrl();

    const response = await axios.get(`${baseUrl}:8000/api/exercises_check_theme`, {
      params: searchParams,
      withCredentials: true,
      headers: {
        'X-XSRF-TOKEN': decodeURIComponent(getCookie('XSRF-TOKEN')),
        'Accept': 'application/json, text/plain, */*',
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
      }
    });

    // Обработка ответа
    if (response.data.exists) {
      console.log('Тема существует');
      // theme_items.value = null;
      theme_items.value = [{name: search_theme.value}];
      return true;
    } else {
      theme_items.value = null;
      console.log('Тема не найдена');
      return false;
    }
  } catch (error) {
    console.error('Ошибка при поиске темы:', error);
    return false;
  }
};
//Активная тема
function download_active_theme(val){
  active_params_task.theme_active = val;
  fetchExercises();
}
const amount_task = ref(null);
const page_tasks = ref(1);
const tasks = reactive([
  // Пример начальных данных
  // { number: 1, content: 'Content 1', type: 'Type 1', description: 'Description 1', true_answer: 'Answer 1', keywords: 'Keywords 1,Ало' },
  // Другие задания...
]);
const splitKeywords = (keywords) => {
  return keywords ? keywords.split(',') : [];
};
const removeKeyword = (item, keywordToRemove) => {
  item.true_keywords = item.true_keywords.split(',')
      .filter(keyword => keyword.trim() !== keywordToRemove.trim())
      .join(',');
};
const addKeyword = (item) => {
  const trimmedKeyword = item.tempKeyword.trim();
  if (trimmedKeyword) {
    item.true_keywords = item.true_keywords
        ? `${item.true_keywords},${trimmedKeyword}`
        : trimmedKeyword;
    item.tempKeyword = '';
  }
};
//Получение заданий
const fetchExercises = async () => {
  try {
    // Получение CSRF токена
    await fetchCsrfToken();
    // Определение параметров запроса
    const searchParams = {
      id_lang_task: active_params_task.task_lang_active?.id,
      id_lang_answer: active_params_task.answer_lang_active?.id,
      id_section: active_params_task.section_active?.id,
      name: active_params_task.theme_active,
      page: page_tasks.value,
    };

    // Отправка запроса на получение заданий
    const baseUrl = getBaseUrl();

    const response = await axios.get(`${baseUrl}:8000/api/get-exercises`, {
      params: searchParams,
      withCredentials: true,
      headers: {
        'X-XSRF-TOKEN': decodeURIComponent(getCookie('XSRF-TOKEN')),
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
      }
    });

    const updatedTasks = response.data.exercises.data.map(task => {
      return {
        ...task,
        tempKeyword: '',
        alert_message: ''
      };
  });

// Обновление реактивных переменных данными
  tasks.splice(0, tasks.length, ...updatedTasks);
    amount_task.value = response.data.count_size;

  } catch (error) {
    console.error('Ошибка при получении заданий:', error);
  }
};

//Подгрузка ещё заданий
const fetchExercises_more = async () => {
  const newPage = page_tasks.value + 1;
  const maxPages = Math.ceil(amount_task.value / 10);

  if (newPage <= maxPages) {
    try {
      // Получение CSRF токена
      await fetchCsrfToken();

      // Определение параметров запроса
      const searchParams = {
        id_lang_task: active_params_task.task_lang_active?.id,
        id_lang_answer: active_params_task.answer_lang_active?.id,
        id_section: active_params_task.section_active?.id,
        name: active_params_task.theme_active,
        page: newPage,
      };

      // Отправка запроса на получение заданий
      const baseUrl = getBaseUrl();

      const response = await axios.get(`${baseUrl}:8000/api/get-exercises`, {
        params: searchParams,
        withCredentials: true,
        headers: {
          'X-XSRF-TOKEN': decodeURIComponent(getCookie('XSRF-TOKEN')),
          'Accept': 'application/json',
          'Content-Type': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
        }
      });

      // Обновление реактивных переменных данными
      if (response.data.exercises.data.length) {
        tasks.push(...response.data.exercises.data);
        page_tasks.value = newPage;
        amount_task.value = response.data.count_size;
      }

    } catch (error) {
      console.error('Ошибка при получении заданий:', error);
    }
  }
};
//Активная тема конец

//Подгрузка при скроле заданий
const loadingRef = ref(null);
let observer;
const onIntersect = (entries) => {
  if (entries[0].isIntersecting && active_params_task.theme_active != null) {
    fetchExercises_more();
  }
};

onMounted(() => {
  observer = new IntersectionObserver(onIntersect, { threshold: 1.0 });
});

onUnmounted(() => {
  if (observer) {
    observer.disconnect();
  }
});

watch(() => active_params_task.theme_active, (newValue) => {
  if (newValue != null && loadingRef.value) {
    observer.observe(loadingRef.value);
  } else if (observer) {
    observer.disconnect();
  }
});

//Редактирование активной темы
 //alerts status
const status_alert = ref(false);
const style_alert = ref(null);
const message_alert = ref(null);
const status_click = ref(null);

function disable_buttons(){
  status_click.value='disable_click';
  setTimeout(() => {
    status_click.value=null;
  }, 4000);
}
function save_themes(styles,description){
 disable_buttons();
  alert_mes(styles,description);
}
function add_task(){
  disable_buttons();
  addExercise();
}
function alert_mes(styles,description){
  status_alert.value = true;
  style_alert.value  = styles;
  message_alert.value  = description;
  setTimeout(() => {
    style_alert.value  = 'opacity_effect_off';
  }, 3000);
  setTimeout(() => {
    status_alert.value = false;
    style_alert.value  = null;
    message_alert.value  = null;
  }, 4000);
}
//alert_end
//Удаление темы
function delete_task(){
  disable_buttons();
  deleteExercises();
}
const deleteExercises = async () => {
  try {
    // Получение CSRF токена
    await fetchCsrfToken();

    // Отправка запроса на удаление заданий
    const baseUrl = getBaseUrl();

    const response = await axios.post(`${baseUrl}:8000/api/delete-exercises`, {
      id_lang_task: active_params_task.task_lang_active?.id,
      id_lang_answer: active_params_task.answer_lang_active?.id,
      id_section: active_params_task.section_active?.id,
      name: active_params_task.theme_active,
    }, {
          withCredentials: true,
          headers: {
            'X-XSRF-TOKEN': decodeURIComponent(getCookie('XSRF-TOKEN')),
            'Accept': 'application/json',
            'Content-Type': 'application/json',
          }
        });

    console.log('Ответ сервера:', response.data);
    alert_mes('mcor alert_delete', 'Тема удалена');
    amount_task.value = null;
    active_params_task.theme_active=null;
    await fetchThemes(1);
  } catch (error) {
    console.error('Ошибка при удалении заданий:', error);
    alert_mes('mcor alert_info', 'Ошибка при удалении темы');
  }
};
//Конец удаления темы
//Добавление задания

const addExercise = async () => {
  try {
    // Получение CSRF токена
    await fetchCsrfToken();

    // Отправка запроса на добавление задания
    const baseUrl = getBaseUrl();

    const response = await axios.post(`${baseUrl}:8000/api/add-exercise`, {
      id_lang_task: active_params_task.task_lang_active?.id,
      id_lang_answer: active_params_task.answer_lang_active?.id,
      id_section: active_params_task.section_active?.id,
      name: active_params_task.theme_active,
    }, {
      withCredentials: true,
      headers: {
        'X-XSRF-TOKEN': decodeURIComponent(getCookie('XSRF-TOKEN')),
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      }
    });

    // Добавление нового задания в массив tasks и обновление количества заданий
    if (response.data && response.status === 201) {
      tasks.push(response.data);
      amount_task.value = (amount_task.value || 0) + 1;
      alert_mes('mcog alert_success', 'Новое задание добавлено');
    }

  } catch (error) {
    console.error('Ошибка при добавлении задания:', error);
    alert_mes('mcor alert_info', 'Ошибка при добавлении задания');
  }
};
//Удаление задания
const deleteThisTask = async (number) => {
  try {
    // Получение CSRF токена
    await fetchCsrfToken();


    // Отправка запроса на удаление заданий
    const baseUrl = getBaseUrl();

    const response = await axios.post(`${baseUrl}:8000/api/delete-task-exercise`, {
      id_lang_task: active_params_task.task_lang_active?.id,
      id_lang_answer: active_params_task.answer_lang_active?.id,
      id_section: active_params_task.section_active?.id,
      name: active_params_task.theme_active,
      number_task: number,
    }, {
      withCredentials: true,
      headers: {
        'X-XSRF-TOKEN': decodeURIComponent(getCookie('XSRF-TOKEN')),
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      }
    });

    console.log('Ответ сервера:', response.data);
    // Удаление задания из массива tasks
    const taskIndex = tasks.findIndex(task => task.number_task === number);
    if (taskIndex !== -1) {
      tasks.splice(taskIndex, 1);
    }
    // amount_task.value--1;
    if(amount_task.value === 1){
      active_params_task.theme_active = null;
    } else{
      amount_task.value--;
    }
    await fetchThemes(1);
  } catch (error) {
    console.error('Ошибка при удалении заданий:', error);
  }
};
//Сохранение измненеия задания по item
const saveData = async (item) => {
  try {
    // Получение CSRF токена, если он ещё не был получен
    await fetchCsrfToken();
    const exerciseData = {
      id: item.id,
      id_lang_task: item.id_lang_task,
      id_lang_answer: item.id_lang_answer,
      id_section: item.id_section,
      name: item.name,
      number_task: item.number_task,
      type: item.type,
      content_name: item.content_name,
      description: item.description,
      true_answer: item.true_answer,
      true_keywords: item.true_keywords
    };
    // console.log(exerciseData);
    // Отправка запроса на сохранение изменений в задании
    const baseUrl = getBaseUrl();

    const response = await axios.put(`${baseUrl}:8000/api/update-exercise`, exerciseData, {
      withCredentials: true,
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        'X-XSRF-TOKEN': decodeURIComponent(getCookie('XSRF-TOKEN')),
      }
    });
    item.alert_message="Сохранения изменены";
    setTimeout(() => {
      item.alert_message = '';
    }, 3000);
    // Здесь можно обработать ответ сервера, например, показать уведомление об успехе
    console.log('Изменения сохранены:', response.data);

  } catch (error) {
    // Обработка возможных ошибок при отправке запроса
    console.error('Ошибка при сохранении изменений:', error);
  }
};
// Конец редактив темы

function active_section(val){
 active_params_task.section_active = val;
}
// const selectedOption_item_task = ref({ name: 'Картинка'});

const options_task_item = ['img', 'video', 'audio', 'text',];

// Добавьте вычисляемое свойство для каждого item в tasks
// tasks.forEach(item => {
//   item.selectedOption = computed(() => {
//     return getOptionByType(item.type);
//   });
// });



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

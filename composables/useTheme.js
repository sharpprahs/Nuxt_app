// // composables/useTheme.js
// import { useState, onMounted } from 'vue'
//
// export const useTheme = () => {
//     const theme = useState('theme', () => 'light')
//
//     const toggleTheme = () => {
//         theme.value = theme.value === 'light' ? 'dark' : 'light'
//         // Сохраняем выбор темы в localStorage
//         localStorage.setItem('theme', theme.value)
//         // Обновляем атрибут data-theme
//         document.documentElement.setAttribute('data-theme', theme.value)
//     }
//
//     onMounted(() => {
//         // Этот код должен только устанавливать атрибут data-theme на основе текущего состояния
//         document.documentElement.setAttribute('data-theme', theme.value)
//     })
//
//     return { theme, toggleTheme }
// }

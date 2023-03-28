/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '@fortawesome/fontawesome-free/css/all.css'
import './styles/app.scss';
import { createApp } from 'vue';
import ListeCourses from './js/ListeCourses.vue'
import HistoriqueDesCourses from './js/HistoriqueDesCourses.vue'
createApp(HistoriqueDesCourses).mount('#historique-course')
createApp(ListeCourses).mount('#liste-course')
import { Tooltip, Toast, Popover } from 'bootstrap';
// start the Stimulus application
import './bootstrap';

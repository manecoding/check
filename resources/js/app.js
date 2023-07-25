import './bootstrap'
import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.css';

window.Swal = Swal;

import { createApp } from 'vue'
import app from './app.vue'
import './assets/style.css'
import router from './routes/index'

createApp(app).use(router).mount('#app')

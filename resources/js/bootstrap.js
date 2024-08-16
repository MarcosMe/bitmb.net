import axios from 'axios';
import Alpine from 'alpinejs';

Alpine.start();

window.axios = axios;

window.Alpine = Alpine;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

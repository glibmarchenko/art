/**
 * TODO: Uncomment, when application will be RESTful
 * const defaultLang = 'en'
 * const availableLags = ['ru', 'en']
 *
 * let lang = require('browser-locale')()
 *
 * if (lang && availableLags.includes(lang.substring(0, 2))) {
 *   document.documentElement.lang = lang.substring(0, 2)
 * } else {
 *   document.documentElement.lang = defaultLang
 * }
 */

import axios from 'axios';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['Content-Type'] = 'application/x-www-form-urlencoded';
window.axios.defaults.headers.common.Accept = 'application/json';

const token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
  window.console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

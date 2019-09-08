import _ from 'lodash';
import jQuery from 'jquery';
import Popper from 'popper.js';
import 'bootstrap';
import axios from 'axios';
import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue'
import Pusher from 'pusher-js';

window.Vue = Vue;
window.axios = axios;
window._ = _;
window.$ = window.jQuery = jQuery;
Vue.use(BootstrapVue);
window.Pusher = Pusher;


window.ScanNotification = new Vue();

Vue.prototype.$http = axios;

window.Popper = Popper.default;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}


import _ from 'lodash';
import jQuery from 'jquery';
import Popper from 'popper.js';
import 'bootstrap';
import axios from 'axios';
import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue'
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Vue = Vue;
window.axios = axios;
window._ = _;
window.$ = window.jQuery = jQuery;
Vue.use(BootstrapVue);
window.Pusher = Pusher;

export const ScanNotification = new Vue();

Vue.prototype.$echo = new Echo({
    broadcaster: 'pusher',
    key: 'f0e241034374b7089f0e',
    cluster: "eu",
    forceTLS: true,
});

Vue.prototype.$http = axios;

window.Popper = Popper.default;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}


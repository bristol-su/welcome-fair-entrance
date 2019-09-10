// Imports
import _ from 'lodash';
import jQuery from 'jquery';
import Popper from 'popper.js';
import 'bootstrap';
import axios from 'axios';
import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue'
import Pusher from 'pusher-js';
import store from './store/store';
import Echo from 'laravel-echo'

// Window assignments
window.Pusher = Pusher;
window.Vue = Vue;
window.axios = axios;
window._ = _;
window.$ = window.jQuery = jQuery;
window.Popper = Popper.default;

//Vue
Vue.use(BootstrapVue);

// Axios
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
Vue.prototype.$http = axios;

// Echo
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    encrypted: true
});

// Vuex
window.store = store;
store.dispatch('refreshScans');

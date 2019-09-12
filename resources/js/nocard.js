import Popper from 'popper.js';
import 'bootstrap';
import axios from 'axios';
import Vue from 'vue';
import {BRow, BForm, BTable, BButton, BFormInput, BCol, BButtonGroup} from 'bootstrap-vue';
import NoCard from './components/qrcode/NoCard';

// Window assignments
window.Vue = Vue;
window.axios = axios;
window.Popper = Popper.default;

// Axios
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
Vue.prototype.$http = axios;
Vue.component('b-row', BRow);
Vue.component('b-col', BCol);
Vue.component('b-button-group', BButtonGroup);
Vue.component('b-form', BForm);
Vue.component('b-table', BTable);
Vue.component('b-button', BButton);
Vue.component('b-form-input', BFormInput);

let vue = new Vue({
    el: '#content',
    components: {
        NoCard,
    }
});

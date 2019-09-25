// Imports
import {debounce} from 'lodash';
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
window.Popper = Popper.default;

//Vue
Vue.use(BootstrapVue);
Vue.prototype.$debounce = debounce;

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
    wsHost: window.location.hostname,
    wsPort: 6001,
    encrypt: true,    
    disableStats: true,
});

// Vuex
window.store = store;

import Dashboard from './components/dashboard/Dashboard';
import Demographics from "./components/demographics/Demographics";
import ScanCreate from "./components/scan/create/Create";
import ScanIndex from "./components/scan/index/Index";
import UidIndex from './components/manualentry/Index';

window.Echo.channel('welcome-fair')
    .listen('ScanUpdated', (event) => {
        store.dispatch('pushOrReplaceScan', event.scan);
    });

export const ScanNotification = new Vue({
    store,
    methods: {
        toggleUpdates() {
            this.$store.commit('setUpdates', !this.updates);
        },

        notify() {
            if (this.$store.getters.updates === true) {
                this.$emit('scan');
            }
        }
    }
});

window.ScanNotification = ScanNotification;

let vue = new Vue({
    el: '#content',
    store,
    components: {
        Dashboard,
        Demographics,

        ScanIndex,
        ScanCreate,

        UidIndex,
    },

    created() {
        this.getScans();
    },

    methods: {
        getScans() {
            this.$http.get('/api/scan/count')
                .then(countResponse => {
                    let numPages = 10;
                    let numPerPage = Math.round(parseInt(countResponse.data) / numPages);
                    let calls = [];
                    for (let i = 1; i <= numPages; i++) {
                        calls.push(this.$http.get('/api/scan', {params: {page: i, per_page: numPerPage }}));
                    }
                    this.$http.all(calls)
                        .then(responses => responses.forEach((response) => this.pushScans(response.data.data)))
                        .catch(error => console.log(error))
                        .then(() => window.ScanNotification.$emit('scan'));
                });
            this.$http.get('/api/scan')
                .then(firstResponse => {

                })
                .catch(error => console.log(error));
        },

        pushScans(scans) {
            this.$store.commit('pushScans', scans)
        }
    }
});

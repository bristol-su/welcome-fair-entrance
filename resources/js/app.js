require('./bootstrap');
import Dashboard from './components/dashboard/Dashboard';
import Demographics from "./components/demographics/Demographics";
import ScanCreate from "./components/scan/create/Create";
import ScanIndex from "./components/scan/index/Index";
import UidIndex from './components/uid/index/Index';

import NoCardIndex from './components/nocard/index/Index';
import NoCardCreate from './components/nocard/create/Create';

import store from './store/store';
import Echo from "laravel-echo";

window.store = store;

store.dispatch('refreshScans');

let echo = new Echo({
    broadcaster: 'pusher',
    key: 'f0e241034374b7089f0e',
    cluster: "eu",
    forceTLS: true,
});

echo.channel('welcome-fair')
    .listen('ScanUpdated', (event) => {
        store.dispatch('pushOrReplaceScan', event.scan);
    });

let vue = new Vue({
    el: '#content',
    store,
    components: {
        Dashboard,
        Demographics,

        ScanIndex,
        ScanCreate,

        UidIndex,

        NoCardIndex,
        NoCardCreate
    }
});

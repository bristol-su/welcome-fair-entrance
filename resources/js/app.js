require('./bootstrap');
import Dashboard from './components/dashboard/Dashboard';
import Demographics from "./components/demographics/Demographics";
import ScanCreate from "./components/scan/create/Create";
import ScanIndex from "./components/scan/index/Index";
import UidIndex from './components/manualentry/Index';

import NoCard from './components/qrcode/NoCard';

window.Echo.channel('welcome-fair')
    .listen('ScanUpdated', (event) => {
        store.dispatch('pushOrReplaceScan', event.scan);
    });

export const ScanNotification = new Vue();
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

        NoCard
    }
});

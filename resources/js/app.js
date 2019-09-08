require('./bootstrap');

import Dashboard from './components/dashboard/Dashboard';
import Demographics from "./components/demographics/Demographics";
import ScanCreate from "./components/scan/create/Create";
import ScanIndex from "./components/scan/index/Index";
import UidIndex from './components/uid/index/Index';

let vue = new Vue({
    el: '#content',
    components: {
        Dashboard,
        Demographics,

        ScanIndex,
        ScanCreate,

        UidIndex
    }
});

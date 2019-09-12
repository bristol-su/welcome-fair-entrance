import Vue from 'vue'
import Vuex from 'vuex'
import {differenceInMilliseconds, isWithinInterval, isEqual, subHours, isBefore} from 'date-fns';

Vue.use(Vuex);

const state = {
    scans: [],
    updates: true
};

const getters = {
    scans: (state) => {
        return state.scans;
    },

    updates: (state) => {
        return state.updates;
    },

    bins: (state, getters) => (numberOfBins) => {
        let lower = getters.scannedAtLowerLimits;
        let upper = getters.scannedAtUpperLimits;
        let increment = differenceInMilliseconds(upper, lower) / parseInt(numberOfBins);
        let bins = [];
        let currentTimestamp = lower;
        for (let i=0;i < parseInt(numberOfBins);i++) {
            bins.push(currentTimestamp);
            currentTimestamp = Math.round(currentTimestamp + increment);
        }
        return bins;
    },

    scansInInterval: (state, getters) => (lower, upper) => {
        return state.scans.filter(scan => {
            let dateScanned = new Date(scan.scanned_at*1000);
            return isWithinInterval(dateScanned, {start: lower, end: upper}) || (isEqual(dateScanned, lower));
        })
    },

    scannedAtLowerLimits: (state, getters) => {
        return getters.scannedAtLimits[0];
    },

    scannedAtUpperLimits: (state, getters) => {
        return getters.scannedAtLimits[1];
    },

    scannedAtLimits: (state) => {
        let limits = state.scans.reduce((acc, val) => {
            let timestamp = new Date(val.scanned_at * 1000).getTime();
            acc[0] = ( acc[0] === undefined || isBefore(timestamp, acc[0]) ) ? timestamp : acc[0];
            acc[1] = ( acc[1] === undefined || isBefore(acc[1], timestamp) ) ? timestamp : acc[1];
            return acc;
        }, []);
        if(limits.length === 2) {
            return limits;
        }
        return [subHours(new Date(), 5).getTime(), new Date().getTime()]
    }
};

const actions = {


    pushScan: ({commit}, scan) => {
        commit('pushScan', scan);
    },

    replaceScan: ({commit}, scan) => {
        commit('replaceScan', scan);
    },

    pushOrReplaceScan: ({commit}, scan) => {
        if(state.scans.filter(scanMap=>scanMap.id === scan.id).length === 1) {
            commit('replaceScan', scan);
        } else {
            commit('pushScan', scan);
        }
    }
};

const mutations = {
    pushScan (state, scan) {
        state.scans.push(scan);
        window.ScanNotification.notify();
    },

    replaceScan(state, scan) {
        state.scans.splice(
            state.scans.map(scansMap => scansMap.id).indexOf(scan.id),
            1,
            scan
        );
        window.ScanNotification.notify();
    },

    setScans(state, scans) {
        state.scans = scans;
        window.ScanNotification.notify();
    },

    setUpdates(state, updates) {
        state.updates = updates;
    }
};

export default new Vuex.Store({
    state,
    getters,
    actions,
    mutations,
})

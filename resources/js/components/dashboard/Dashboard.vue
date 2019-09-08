<template>
    <div>
        <overview
            :scans="scans">

        </overview>

        <TimeOfEntry
            :scans="scans">

        </TimeOfEntry>


        <TimeOfEntryCMvsNonCM
            :scans="scans">

        </TimeOfEntryCMvsNonCM>
    </div>

</template>


<script>
    import Overview from './Charts/Overview';
    import TimeOfEntry from "./Charts/TimeOfEntry";
    import {ScanNotification} from "../../bootstrap";
    import TimeOfEntryCMvsNonCM from "./Charts/TimeOfEntryCMvsNonCM";

    export default {
        data() {
            return {
                scans: []
            }
        },

        components: {TimeOfEntryCMvsNonCM, TimeOfEntry, Overview},

        created() {
            this.$echo.channel('welcome-fair')
                .listen('ScanUpdated', (event) => {
                    this.replaceScan(event.scan);
                    ScanNotification.$emit('scan', event.scan);
                })
                .listen('ScanCreated', (event) => {
                    this.appendScan(event.scan);
                    ScanNotification.$emit('scan', event.scan);
                });
            this.getScans();

        },

        methods: {
            getScans() {
                this.$http.get('/api/scan')
                    .then(response => {
                        response.data.forEach(scan => this.appendScan(scan));
                    })
                    .catch(error => console.log(error));
            },

            appendScan(scan) {
                this.scans.push(scan);
            },

            replaceScan(scan) {
                this.scans.splice(this.scans.map(scansMap => scansMap.id).indexOf(scan.id), 1, scan);
            },
        },


    }
</script>

<style>

</style>

<template>
    <div>
        <b-card no-body>
            <b-tabs card>
                <b-tab title="Totals" active>
                    <b-card-text>
                        <department-total :scans="scans"> :scans="scans"></department-total>
                        <study-type-total :scans="scans"> :scans="scans"></study-type-total>
                        <year-total :scans="scans"></year-total>
                        <gender-total :scans="scans"></gender-total>
                        <age-total :scans="scans"></age-total>
                    </b-card-text>
                </b-tab>
                <b-tab title="Over Time">
                    <b-card-text>
                        <department-time :scans="scans"> :scans="scans"></department-time>
                        <study-type-time :scans="scans"> :scans="scans"></study-type-time>
                        <year-time :scans="scans"></year-time>
                        <gender-time :scans="scans"></gender-time>
                        <age-time :scans="scans"></age-time>
                    </b-card-text>
                </b-tab>
            </b-tabs>
        </b-card>
    </div>

</template>


<script>
    import {ScanNotification} from "../../bootstrap";
    import DepartmentTotal from './Charts/Totals/Department';
    import StudyTypeTotal from './Charts/Totals/StudyType';
    import YearTotal from './Charts/Totals/Year';
    import GenderTotal from './Charts/Totals/Gender';
    import AgeTotal from './Charts/Totals/Age';

    import DepartmentTime from './Charts/Time/Department';
    import StudyTypeTime from './Charts/Time/StudyType';
    import YearTime from './Charts/Time/Year';
    import GenderTime from './Charts/Time/Gender';
    import AgeTime from './Charts/Time/Age';
    export default {
        data() {
            return {
                scans: []
            }
        },

        components: {
            DepartmentTotal, DepartmentTime,
            StudyTypeTotal, StudyTypeTime,
            YearTotal, YearTime,
            GenderTotal, GenderTime,
            AgeTotal, AgeTime
        },

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

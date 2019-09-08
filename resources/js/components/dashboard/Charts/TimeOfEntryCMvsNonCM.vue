<template>
    <data-container title="Time of entry by committee member/other">
        <b-form-group label="Chart Type" label-for="chart-type">
            <b-form-radio-group
                id="chart-type"
                v-model="chartType"
                :options="chartTypeOptions"
                buttons
            ></b-form-radio-group>
        </b-form-group>
        <b-form-group label="Number of Bins" label-for="binCount">
            <b-form-input id="binCount" type="number" v-model="binCount"></b-form-input>
        </b-form-group>
        <vue-apex-charts :options="options" :series="series" :type="chartType">

        </vue-apex-charts>
    </data-container>
</template>

<script>
    import VueApexCharts from 'vue-apexcharts'
    import DataContainer from "../../utilities/DataContainer";
    import {subHours, isBefore, differenceInMilliseconds, isWithinInterval, isEqual} from 'date-fns';

    export default {
        name: 'TimeOfEntryCMvsNonCM',
        components: {DataContainer, VueApexCharts},

        data() {
            return {
                options: {
                    xaxis: {
                        type: 'datetime',
                    }
                },
                series: [],
                binCount: 15,
                chartType: 'line',
                chartTypeOptions: [
                    {value: 'line', text: 'Line Graph'},
                    {value: 'bar', text: 'Bar Graph'},
                    {value: 'area', text: 'Area Graph'},
                ]
            }
        },

        mounted() {
            window.ScanNotification.$on('scan', () => this.updateSeries() );
        },

        watch: {
            binCount() {
                this.updateSeries();
            },
            chartType() {
                this.updateSeries();
            },
        },

        methods: {
            updateSeries() {
                this.series = [{
                    name: 'Committee Members',
                    data: this.cmSeriesData
                }, {
                    name: 'Non Committee Members',
                    data: this.ncmSeriesData
                }];
            },


        },

    computed: {
        cmSeriesData() {
            let bins = this.$store.getters.bins(this.binCount);
            let seriesData = [];
            for (let i = 0; i < bins.length - 1; i++) {
                let until = (bins[i + 1] ? new Date(bins[i + 1]) : new Date());
                seriesData.push([bins[i], this.$store.getters.scansInInterval(new Date(bins[i]), until)
                    .filter(scan => scan.committee_member === true).length]);
            }
            return seriesData;
        },

        ncmSeriesData() {
            let bins = this.$store.getters.bins(this.binCount);
            let seriesData = [];
            for (let i = 0; i < bins.length - 1; i++) {
                let until = (bins[i + 1] ? new Date(bins[i + 1]) : new Date());
                seriesData.push([bins[i], this.$store.getters.scansInInterval(new Date(bins[i]), until)
                    .filter(scan => scan.committee_member === false).length]);
            }
            return seriesData;
        }
    }
    }
</script>

<template>
    <data-container title="Year of Study">
        <b-form-group label="Chart Type" label-for="chart-type">
            <b-form-radio-group
                id="chart-type"
                v-model="chartType"
                :options="chartTypeOptions"
                buttons
            ></b-form-radio-group>
        </b-form-group>
        <vue-apex-charts :options="options" :series="series" :type="chartType">

        </vue-apex-charts>
    </data-container>
</template>

<script>
    import DataContainer from "../../../utilities/DataContainer";
    import VueApexCharts from 'vue-apexcharts';
    import _ from 'lodash';
    export default {
        name: "Year",

        components: {
            DataContainer, VueApexCharts
        },

        data() {
            return {
                options: {
                    labels: [],
                },
                series: [],
                chartType: 'area',
                chartTypeOptions: [
                    {value: 'line', text: 'Line Graph'},
                    {value: 'bar', text: 'Bar Graph'},
                    {value: 'area', text: 'Area Graph'},
                    {value: 'pie', text: 'Pie'},
                    {value: 'donut', text: 'Donut'},
                ]
            }
        },

        watch: {
            chartType() {
                this.updateSeries();
            }
        },

        methods: {
            updateSeries: _.throttle(function() {
                let frequency = this.yearsFrequency.sort((a, b) => a.x > b.x ? 1 : -1 );
                if(this.chartType === 'pie' || this.chartType === 'donut') {
                    this.series = frequency.map(freq => freq.y);
                    this.options.labels = frequency.map(freq => freq.x);
                } else {
                    this.series = [{name: 'Entrances', data: frequency}];
                    this.options.labels = []
                }
            }, 3000),
        },

        mounted() {
            window.ScanNotification.$on('scan', () => this.updateSeries() );
        },

        computed: {
            yearsFrequency() {
                let frequency = {};
                this.$store.getters.scans.forEach(scan => {
                    if(frequency['Year ' + scan.programme_year] !== undefined) {
                        frequency['Year ' + scan.programme_year]++;
                    } else {
                        frequency['Year ' + scan.programme_year] = 1;
                    }
                });
                return Object.keys(frequency).map(label => {
                    return {x: label, y: frequency[label]};
                });
            }
        }

    }
</script>

<style scoped>

</style>

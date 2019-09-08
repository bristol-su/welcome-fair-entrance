<template>
    <data-container title="Gender">
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
    export default {
        name: "Gender",

        components: {
            DataContainer, VueApexCharts
        },

        data() {
            return {
                options: {
                    labels: [],
                },
                series: [],
                chartType: 'donut',
                chartTypeOptions: [
                    {value: 'bar', text: 'Bar Graph'},
                    {value: 'pie', text: 'Pie'},
                    {value: 'donut', text: 'Donut'},
                ]
            }
        },

        mounted() {
            window.ScanNotification.$on('scan', () => this.updateSeries() );
        },

        watch: {
            chartType() {
                this.updateSeries();
            }
        },

        methods: {
            updateSeries() {
                let frequency = this.typeFrequency;
                if(this.chartType === 'pie' || this.chartType === 'donut') {
                    this.series = frequency.map(freq => freq.y);
                    this.options.labels = frequency.map(freq => freq.x);
                } else {
                    this.series = [{name: 'Entrances', data: frequency}];
                    this.options.labels = []
                }
            },
        },

        computed: {
            typeFrequency() {
                let frequency = {};
                this.$store.getters.scans.forEach(scan => {
                    if(frequency[scan.gender] !== undefined) {
                        frequency[scan.gender]++;
                    } else {
                        frequency[scan.gender] = 1;
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

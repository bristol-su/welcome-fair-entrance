
<template>
    <data-container title="Time of entry">
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
    import _ from 'lodash';

    export default {
        name: 'TimeOfEntry',
        components: {DataContainer, VueApexCharts},

        data() {
            return {
                options: {
                    xaxis: {
                        type: 'datetime',
                    },
                    tooltip: {
                        x: {
                            format: 'dd/mm/yy HH:mm',
                        },
                    }
                },
                series: [],
                binCount: 15,
                chartType: 'area',
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
            }
        },

        methods: {
            updateSeries: _.throttle(function() {
                this.series = [{
                    name: 'Entrances',
                    data: this.seriesData
                }];
            }, 3000),
        },

        computed: {
            seriesData() {
                let bins = this.$store.getters.bins(this.binCount);
                let seriesData = [];
                for(let i = 0; i < bins.length;i++) {
                    let until = (bins[i+1] ? new Date(bins[i+1]) : new Date());
                    seriesData.push([bins[i], this.$store.getters.scansInInterval(new Date(bins[i]), until).length]);
                }
                return seriesData;
            },
        }
    }
</script>

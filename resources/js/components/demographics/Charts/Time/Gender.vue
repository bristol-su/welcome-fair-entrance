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
        <b-form-group label="Number of Bins" label-for="binCount">
            <b-form-input id="binCount" type="number" v-model="binCount"></b-form-input>
        </b-form-group>
        <vue-apex-charts :options="options" :series="series" :type="chartType">

        </vue-apex-charts>
    </data-container>
</template>

<script>
    import DataContainer from "../../../utilities/DataContainer";
    import VueApexCharts from 'vue-apexcharts';
    import {subHours, isBefore, differenceInMilliseconds, isWithinInterval, isEqual} from 'date-fns';
    import _ from 'lodash';


    export default {
        name: "GenderTime",
        components: {
            DataContainer, VueApexCharts
        },

        mounted() {
            window.ScanNotification.$on('scan', () => this.updateSeries());
        },

        data() {
            return {
                options: {
                    xaxis: {
                        type: 'datetime',
                    },
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

        watch: {
            binCount() {
                this.updateSeries();
            },
            chartType() {
                this.updateSeries();
            },
        },

        methods: {
            updateSeries: _.throttle(function() {
                this.series = this.seriesData;
            }, 3000),
        },

        computed: {
            seriesData() {
                let bins = this.$store.getters.bins(this.binCount);
                let seriesData = [];
                for(let i = 0; i < bins.length;i++) {
                    let until = (bins[i+1] ? new Date(bins[i+1]) : new Date());
                    let res = this.$store.getters.scansInInterval(new Date(bins[i]), until)
                        .reduce((agg, val) => {
                            if(agg[val.gender] !== undefined) {
                                agg[val.gender]++;
                            } else {
                                agg[val.gender] = 1;
                            }
                            return agg;
                        }, {});
                    Object.keys(res).forEach(gender => {
                        if(seriesData[gender] === undefined) {
                            seriesData[gender] = [];
                        }
                        seriesData[gender].push([bins[i], res[gender]]);
                    })
                }
                return Object.keys(seriesData).map(gender => {
                    return {name: gender, data: seriesData[gender]};
                });
            },

        }

    }
</script>



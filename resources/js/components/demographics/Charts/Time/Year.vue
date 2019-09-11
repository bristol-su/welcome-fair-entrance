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
        name: "YearTime",
        components: {
            DataContainer, VueApexCharts
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
                            if(agg['Year ' + val.programme_year] !== undefined) {
                                agg['Year ' + val.programme_year]++;
                            } else {
                                agg['Year ' + val.programme_year] = 1;
                            }
                            return agg;
                        }, {});
                    Object.keys(res).forEach(year => {
                        if(seriesData[year] === undefined) {
                            seriesData[year] = [];
                        }
                        seriesData[year].push([bins[i], res[year]]);
                    })
                }
                return Object.keys(seriesData).map(year => {
                    return {name: year, data: seriesData[year]};
                });
            },

        }

    }
</script>



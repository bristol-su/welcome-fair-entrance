<template>
    <data-container title="Age">
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


    export default {
        name: "AgeTime",
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
            updateSeries() {
                this.series = this.seriesData;
            },
        },

        computed: {
            seriesData() {
                let bins = this.$store.getters.bins(this.binCount);
                let seriesData = [];
                for(let i = 0; i < bins.length;i++) {
                    let until = (bins[i+1] ? new Date(bins[i+1]) : new Date());
                    let res = this.$store.getters.scansInInterval(new Date(bins[i]), until)
                        .reduce((agg, val) => {
                            if(agg[val.age] !== undefined) {
                                agg[val.age]++;
                            } else {
                                agg[val.age] = 1;
                            }
                            return agg;
                        }, {});
                    Object.keys(res).forEach(age => {
                        if(seriesData[age] === undefined) {
                            seriesData[age] = [];
                        }
                        seriesData[age].push([bins[i], res[age]]);
                    })
                }
                return Object.keys(seriesData).map(age => {
                    return {name: age, data: seriesData[age]};
                });
            },

        }

    }
</script>



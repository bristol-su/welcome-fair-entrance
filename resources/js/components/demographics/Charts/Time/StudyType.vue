<template>
    <data-container title="Study Type">
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
        name: "StudyTypeTime",
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

        watch: {
            binCount() {
                this.updateSeries();
            },
            chartType() {
                this.updateSeries();
            },
        },

        mounted() {
            window.ScanNotification.$on('scan', () => this.updateSeries() );
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
                            if(agg[val.study_type] !== undefined) {
                                agg[val.study_type]++;
                            } else {
                                agg[val.study_type] = 1;
                            }
                            return agg;
                        }, {});
                    Object.keys(res).forEach(study_type => {
                        if(seriesData[study_type] === undefined) {
                            seriesData[study_type] = [];
                        }
                        seriesData[study_type].push([bins[i], res[study_type]]);
                    })
                }
                return Object.keys(seriesData).map(study_type => {
                    return {name: study_type, data: seriesData[study_type]};
                });
            },

        }

    }
</script>



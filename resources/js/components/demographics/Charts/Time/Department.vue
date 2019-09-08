<template>
    <data-container title="Department">
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
        name: "DepartmentTime",
        components: {
            DataContainer, VueApexCharts
        },

        props: {
            scans: {
                type: Array,
                default: function() {
                    return [];
                }
            },
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
            scans: {
                handler: function() {
                    this.updateSeries();
                },
                deep: true
            }
        },

        methods: {
            updateSeries() {
                this.series = this.seriesData;
            },


        },

        computed: {
            seriesData() {
                let bins = this.bins;
                let binData = {};
                for(let i = 0; i < bins.length-1;i++) {
                    let res = this.scans.filter(scan => { // Get only scans in this interval
                        return isWithinInterval(
                            new Date(scan.scanned_at*1000),
                            {start: new Date(bins[i]), end: new Date(bins[i+1])}
                        ) || (isEqual(new Date(scan.scanned_at*1000), new Date(bins[i])));
                    }).reduce((agg, val) => {
                        if(agg[val.department] !== undefined) {
                            agg[val.department]++;
                        } else {
                            agg[val.department] = 1;
                        }
                        return agg;
                    }, {});
                    Object.keys(res).forEach(department => {
                        if(binData[department] === undefined) {
                            binData[department] = [];
                        }
                        binData[department].push([bins[i], res[department]]);
                    })
                }
                return Object.keys(binData).map(department => {
                    return {name: department, data: binData[department]};
                });
            },

            bins() {
                let timestampLimits = this.timestampLimits;
                let increment = differenceInMilliseconds(timestampLimits[1], timestampLimits[0]) / (this.binCount>0?this.binCount:1);
                let currentTimestamp = timestampLimits[0];
                let bins = [currentTimestamp];
                while (currentTimestamp <= timestampLimits[1]) {
                    currentTimestamp = currentTimestamp + increment;
                    bins.push(currentTimestamp);
                }
                return bins;
            },

            timestampLimits() {
                let limits = this.scans.reduce((acc, val) => {
                    let timestamp = new Date(val.scanned_at * 1000).getTime();
                    acc[0] = ( acc[0] === undefined || isBefore(timestamp, acc[0]) ) ? timestamp : acc[0];
                    acc[1] = ( acc[1] === undefined || isBefore(acc[1], timestamp) ) ? timestamp : acc[1];
                    return acc;
                }, []);
                if(limits.length === 2) {
                    return limits;
                }
                return [subHours(new Date(), 5).getTime(), new Date().getTime()]
            },
        }

    }
</script>



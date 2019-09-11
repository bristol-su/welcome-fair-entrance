<template>

    <data-container title="Overview">

        <div class="card-bg-secondary">
            <div class="d-flex">
                <div class="w-50 border-right border-bottom">
                    <div class="p-4">
                        <small class="text-uppercase">Total Scans</small>

                        <h4 class="mt-4 mb-0">
                            {{ scanCount }}
                        </h4>
                    </div>
                </div>

                <div class="w-50 border-right border-bottom">
                    <div class="p-4">
                        <small class="text-uppercase">Scans in the last hour</small>

                        <h4 class="mt-4 mb-0">
                            {{scanCountLastHour}}
                        </h4>
                    </div>
                </div>
            </div>

        </div>
    </data-container>
</template>

<script>
    import DataContainer from "../../utilities/DataContainer";
    import {isWithinInterval, subHours} from 'date-fns';

    export default {

        components: {
            DataContainer
        },

        computed: {
            scanCount() {
                return this.$store.getters.scans.length;
            },

            scanCountLastHour() {
                return this.$store.getters.scans.filter(scan => {
                    return isWithinInterval(
                        new Date(scan.scanned_at * 1000),
                        {start: subHours(new Date(), 1), end: new Date()}
                    );
                }).length;
            },

        }
    }
</script>

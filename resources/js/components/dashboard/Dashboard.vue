<template>
    <div>
        <overview>

        </overview>

        <TimeOfEntry>

        </TimeOfEntry>


        <TimeOfEntryCMvsNonCM>

        </TimeOfEntryCMvsNonCM>
    </div>

</template>


<script>
    import Overview from './Charts/Overview';
    import TimeOfEntry from "./Charts/TimeOfEntry";
    import {ScanNotification} from "../../bootstrap";
    import TimeOfEntryCMvsNonCM from "./Charts/TimeOfEntryCMvsNonCM";

    export default {

        components: {TimeOfEntryCMvsNonCM, TimeOfEntry, Overview},

    }
</script>

<style>

</style>

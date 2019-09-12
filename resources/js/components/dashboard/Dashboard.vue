<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="box columnbox mt-4">
                    <overview></overview>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-md-7">
                <div class="box mt-4">
                    <TimeOfEntry></TimeOfEntry>
                </div>
            </div>

            <div class="col-md-5">
                <div class="box  mt-4">
                    <TimeOfEntryCMvsNonCM></TimeOfEntryCMvsNonCM>
                </div>
            </div>
        </div>







    </div>

</template>


<script>
    import Overview from './Charts/Overview';
    import TimeOfEntry from "./Charts/TimeOfEntry";
    import TimeOfEntryCMvsNonCM from "./Charts/TimeOfEntryCMvsNonCM";

    export default {

        components: {TimeOfEntryCMvsNonCM, TimeOfEntry, Overview},

    }
</script>

<style>

</style>

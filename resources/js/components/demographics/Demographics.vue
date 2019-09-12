<template>
    <div>
        <b-card no-body>
            <b-tabs card>
                <b-tab active title="Totals">
                    <b-card-text>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="box mt-4">
                                    <year-total></year-total>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="box  mt-4">
                                    <study-type-total></study-type-total>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="box mt-4">
                                    <department-total></department-total>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="box  mt-4">
                                    <gender-total></gender-total>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box mt-4">
                                    <age-total></age-total>
                                </div>
                            </div>
                        </div>
                    </b-card-text>
                </b-tab>
                <b-tab title="Over Time">
                    <b-card-text>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="box mt-4">
                                    <year-time></year-time>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="box  mt-4">
                                    <study-type-time></study-type-time>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="box mt-4">
                                    <department-time></department-time>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="box  mt-4">
                                    <gender-time></gender-time>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box mt-4">
                                    <age-time></age-time>
                                </div>
                            </div>
                        </div>
                    </b-card-text>
                </b-tab>
            </b-tabs>
        </b-card>
    </div>

</template>


<script>
    import DepartmentTotal from './Charts/Totals/Department';
    import StudyTypeTotal from './Charts/Totals/StudyType';
    import YearTotal from './Charts/Totals/Year';
    import GenderTotal from './Charts/Totals/Gender';
    import AgeTotal from './Charts/Totals/Age';

    import DepartmentTime from './Charts/Time/Department';
    import StudyTypeTime from './Charts/Time/StudyType';
    import YearTime from './Charts/Time/Year';
    import GenderTime from './Charts/Time/Gender';
    import AgeTime from './Charts/Time/Age';

    export default {
        components: {
            DepartmentTotal, DepartmentTime,
            StudyTypeTotal, StudyTypeTime,
            YearTotal, YearTime,
            GenderTotal, GenderTime,
            AgeTotal, AgeTime
        },
    }
</script>

<style>

</style>

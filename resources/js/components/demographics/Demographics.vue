<template>
    <div>
        <b-card no-body>
            <b-tabs card>
                <b-tab active title="Totals">
                    <b-card-text>
                        <department-total></department-total>
                        <study-type-total></study-type-total>
                        <year-total></year-total>
                        <gender-total></gender-total>
                        <age-total></age-total>
                    </b-card-text>
                </b-tab>
                <b-tab title="Over Time">
                    <b-card-text>
                        <department-time></department-time>
                        <study-type-time></study-type-time>
                        <year-time></year-time>
                        <gender-time></gender-time>
                        <age-time></age-time>
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

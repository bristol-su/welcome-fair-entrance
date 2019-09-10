<template>
    <div>

        <div v-if="isCurrentStudent !== true">
            <current-student @input="isCurrentStudent = $event">

            </current-student>
        </div>

        <div v-else>
            <student-finder v-if="!studentChosen" @input="setStudent">

            </student-finder>

            <qr-code v-if="studentChosen" :student="student">

            </qr-code>

        </div>
    </div>

</template>

<script>
    import StudentFinder from './selection/StudentFinder';
    import QrCode from './qrcode/QrCode';
    import CurrentStudent from './currentstudent/CurrentStudent';

    export default {
        name: "NoCard",

        components: {
            CurrentStudent,
            QrCode,
            StudentFinder,
        },

        data() {
            return {
                student: {},
                isCurrentStudent: null
            }
        },

        methods: {
            setStudent(student) {
                this.student = student;
            },

            reset() {
                this.student = null;
            }
        },

        computed: {
            studentChosen() {
                return this.student.hasOwnProperty('uid');
            }
        }

    }
</script>

<style scoped>

</style>

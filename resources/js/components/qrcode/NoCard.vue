<template>
    <div>

        <div v-if="isCurrentStudent === null">
            <current-student @input="isCurrentStudent = $event">

            </current-student>
        </div>

        <div v-if="isCurrentStudent === true">
            <student-finder v-if="!studentChosen" @input="setStudent" @restart="reset">

            </student-finder>

            <qr-code
                v-if="studentChosen"
                :forename="student.forename"
                :surname="student.surname"
                :uid="student.uid"
                :dob="student.dob"
                @restart="reset">

            </qr-code>

        </div>

        <div v-if="isCurrentStudent === false">
            Typeform integration needed
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
                isCurrentStudent: null,
                cookieName: 'bristol-su-welcome-fair-entrance'
            }
        },

        created() {
            if(this.cookieSet) {
                let student = this.cookie;
                this.student = {
                    uid: student.uid,
                    forename: student.forename,
                    surname: student.surname,
                    dob: student.dob
                };
                this.isCurrentStudent = true;
            }
        },

        methods: {
            setStudent(student) {
                this.student = student;
                this.setCookie(student);
            },

            reset() {
                this.student = {};
                this.isCurrentStudent = null;
                this.clearCookie();
            },

            setCookie(student) {
                this.$cookies.set(this.cookieName, JSON.stringify({
                    uid: student.uid, forename: student.forename, surname: student.surname, dob: student.dob
                }), (new Date(Date.now()+ 86400*1000)).toUTCString());
            },
            clearCookie() {
                this.$cookies.remove(this.cookieName);
            }
        },

        computed: {
            studentChosen() {
                return this.student.hasOwnProperty('uid');
            },

            cookieSet() {
                return this.$cookies.isKey(this.cookieName);
            },

            cookie() {
                return this.$cookies.get(this.cookieName);
            }
        }

    }
</script>

<style scoped>

</style>

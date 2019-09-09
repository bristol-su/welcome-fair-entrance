<template>
    <div>
        <b-row style="margin-bottom: 20px;">
            <b-col>
                <b-form @submit.prevent="findStudent">
                    <b-row>
                        <b-col>
                            <h4>Enter your date of birth and surname below.</h4>
                        </b-col>
                    </b-row>
                    <b-row class="my-1">
                        <b-col sm="3">
                            <label :for="dob">Date of Birth (yyyy-mm-dd):</label>
                        </b-col>
                        <b-col sm="9">
                            <b-form-input id="dob" required type="date" v-model="dob"></b-form-input>
                        </b-col>
                    </b-row>
                    <b-row class="my-1">
                        <b-col sm="3">
                            <label :for="lastname">Last Name:</label>
                        </b-col>
                        <b-col sm="9">
                            <b-form-input id="lastname" required type="text" v-model="lastname"></b-form-input>
                        </b-col>
                    </b-row>
                    <b-row class="my-1">
                        <b-col sm="12">
                            <b-button :disabled="loading" type="submit" width="100%">Find Me!</b-button>
                        </b-col>
                    </b-row>
                </b-form>
            </b-col>
        </b-row>
        <b-row v-if="student !== null">
            <b-col>
                <this-is-me :student="student">

                </this-is-me>
            </b-col>
        </b-row>

        <b-row v-if="results.length > 1 && student === null">
            <b-col>
                <these-are-me :results="results" @choose="chosenStudentUid = $event">

                </these-are-me>
            </b-col>
        </b-row>


    </div>

</template>

<script>
    import TheseAreMe from './selection/TheseAreMe';
    import ThisIsMe from './selection/ThisIsMe';

    export default {
        name: "NoCardCreate",

        components: {
            TheseAreMe,
            ThisIsMe
        },

        data() {
            return {
                loading: false,
                dob: null,
                lastname: '',
                results: [],
                chosenStudentUid: null
            }
        },

        methods: {
            findStudent() {
                this.loading = true;
                this.$http.get('/api/uid/search', {
                    params: {dob: this.dob, surname: this.lastname}
                })
                    .then(response => this.results = response.data)
                    .catch(error => console.log(error))
                    .then(() => this.loading = false);
            }
        },

        computed: {
            student() {
                if(this.results.length === 1) {
                    return this.results[0];
                } if(this.chosenStudentUid !== null) {
                    return this.results.filter(student => student.uid === this.chosenStudentUid)[0];
                }
                return null;
            }
        }
    }
</script>

<style scoped>

</style>

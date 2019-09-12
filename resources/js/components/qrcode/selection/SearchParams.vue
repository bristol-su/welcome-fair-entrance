<template>
    <div>
        <b-row style="margin-bottom: 20px;">
            <b-col>
                <b-form @submit.prevent="search">
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
                        <b-col sm="6">
                            <b-button type="submit" width="100%">Find Me!</b-button>
                        </b-col>
                        <b-col sm="6">
                            <b-button variant="danger" @click="$emit('restart')">Restart</b-button>
                        </b-col>
                    </b-row>
                </b-form>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    export default {
        name: "SearchParams",

        data() {
            return {
                dob: null,
                lastname: ''
            }
        },

        methods: {
            search() {
                this.$emit('search', {
                    dob: this.dob, lastname: this.lastname
                })
            }
        },
    }
</script>

<style scoped>

</style>

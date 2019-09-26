<template>
    <div>
        <b-row style="margin-bottom: 20px;">
            <b-col>
                <b-form @submit.prevent="search">
                    <b-row class="title">
                        <b-col>
                            <h4>Enter your date of birth and last name below</h4>
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
                        <b-col sm="6" class="section">
                            <b-button type="submit" class="searchbutton find" :disabled="disableButtons">Find Me!</b-button>
                        </b-col>
                        <b-col sm="6">
                            <b-button @click="$emit('restart')" variant="danger" class="searchbutton restart">Restart</b-button>
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

        props: {
            disableButtons: {
                type: Boolean,
                default: false,
                required: true
            }
        },

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
    .title {
        width: 80%;
        margin: auto;
    }

    .searchbutton {
        width: 70%;
        margin: auto;
    }

    .find {
        background-color: #5eaeba;
        border: 0;
    }

    .restart {

    }

    .section {
        margin-bottom: 3px;
    }
</style>

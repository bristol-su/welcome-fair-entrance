<template>
    <b-row>
        <b-col md="3" sm="6" xs="12">
            <b-form-group
                label="Student ID"
                label-size="sm"
                label-for="student-id"
            >
                <b-input-group size="sm">
                    <b-form-input
                        @input="search('id', $event) "
                        type="search"
                        id="student-id"
                        placeholder="Type to Search"
                    ></b-form-input>
                </b-input-group>
            </b-form-group>
        </b-col>
        <b-col md="3" sm="6" xs="12">
            <b-form-group
                label="Forename"
                label-size="sm"
                label-for="forename"
            >
                <b-input-group size="sm">
                    <b-form-input
                        @input="search('forename', $event) "
                        type="search"
                        id="forename"
                        placeholder="Type to Search"
                    ></b-form-input>
                </b-input-group>
            </b-form-group>
        </b-col>

        <b-col md="3" sm="6" xs="12">
            <b-form-group
                label="Surname"
                label-size="sm"
                label-for="surname"
            >
                <b-input-group size="sm">
                    <b-form-input
                        @input="search('surname', $event) "
                        type="search"
                        id="surname"
                        placeholder="Type to Search"
                    ></b-form-input>
                </b-input-group>
            </b-form-group>
        </b-col>

        <b-col md="3" sm="6" xs="12">
            <b-form-group
                label="Email"
                label-size="sm"
                label-for="email"
            >
                <b-input-group size="sm">
                    <b-form-input
                        @input="search('email', $event) "
                        type="search"
                        id="email"
                        placeholder="Type to Search"
                    ></b-form-input>
                </b-input-group>
            </b-form-group>
        </b-col>

    </b-row>

</template>

<script>

    export default {

        props: {
            value: {
                required: false,
                type: Array,
                default: function() {
                    return [];
                }
            }
        },

        data() {
            return {
                searchFields: {}
            }
        },

        watch: {
            searchFields: {
                deep: true,
                handler: function() {
                    this.$emit('busy', true);
                    this.updateResults();
                }
            }
        },

        methods: {
            search(type, val) {
                if(val === '' || val === null) {
                    this.$delete(this.searchFields, type);
                } else {
                    this.$set(this.searchFields, type, val);
                }
            },

            updateResults: _.debounce(function() {
                this.$emit('busy', true);
                this.$http.get('/api/uid/search', {
                    params: this.searchFields
                })
                    .then(response => this.$emit('input', response.data))
                    .catch(error => console.log(error))
                    .then(() => this.$emit('busy', false));
            }, 800)
        },

    }

</script>

<template>
    <div>
        <search-params v-if="!hasResults" @restart="$emit('restart')" @search="search" :disable-buttons="loading">

        </search-params>

        <select-user v-if="hasResults" :users="results" @restart="$emit('restart')" @reset="reset" @selected="uidChosen">

        </select-user>


    </div>
</template>

<script>
    import SearchParams from './SearchParams';
    import SelectUser from './SelectUser';
    export default {
        name: "StudentFinder",
        components: {SelectUser, SearchParams},
        props: {},

        data() {
            return {
                loading: false,
                results: [],
            }
        },

        methods: {
            search(parameters) {
                this.loading = true;
                this.$http.get('/api/uid', {
                    params: {
                        dob: parameters.dob,
                        surname: parameters.lastname,
                        exact: true
                    }
                })
                    .then(response => this.setResults(response.data))
                    .catch(error => console.log(error))
                    .then(() => this.loading = false);
            },

            reset() {
                this.results = [];
            },

            uidChosen(uid) {
                this.$emit('input', uid)
            },

            setResults(results) {
                if(results.length === 0) {
                    alert('No users found. Speak to someone in a blue Bristol SU t-shirt for help.')
                }
                this.results = results;
            }
        },

        computed: {
            hasResults() {
                return this.results.length > 0;
            },
        }
    }
</script>

<style scoped>

</style>

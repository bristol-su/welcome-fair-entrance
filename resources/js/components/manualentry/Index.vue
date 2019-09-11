<template>
    <div>

        <search-fields v-model="results" @busy="busyState=$event">

        </search-fields>

        <search-table :busyState="busyState" :results="results">

        </search-table>
    </div>
</template>

<script>
    import SearchFields from "./search/SearchFields";
    import SearchTable from './search/Table';

    export default {
        name: "Index",

        components: {SearchFields, SearchTable},

        data() {
            return {
                busyState: false,
                results: [],
            }
        },
    }
</script>

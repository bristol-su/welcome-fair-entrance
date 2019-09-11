<template>
    <div>
        <b-table :items="scanItems"></b-table>
    </div>
</template>

<script>
    export default {
        name: "Index",

        computed: {
            scanItems() {
                return this.$store.getters.scans.sort((a, b) => (b.id - a.id));
            }
        }
    }
</script>

<style>

</style>

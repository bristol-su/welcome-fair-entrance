<template>
    <div>
        <b-table :fields="fields" :items="results">

            <template v-slot:cell(me)="row">
                <b-button @click="choose(row.item.uid)" class="mr-2" size="xs">
                    This is me!
                </b-button>
            </template>

        </b-table>
    </div>

</template>

<script>
    export default {
        name: "TheseAreMe",

        data() {
            return {
                fields: ['id', 'forename', 'surname', 'me']
            }
        },

        props: {
            results: {
                type: Array,
                required: true
            }
        },

        methods: {
            choose(uid) {
                this.$emit('choose', uid);
            }
        }

    }
</script>

<style scoped>

</style>

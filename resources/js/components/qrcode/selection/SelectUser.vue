<template>
    <div>
        <b-button @click="$emit('reset')">Restart</b-button>
        <b-table :fields="fields" :items="users">

            <template v-slot:cell(me)="row">
                <b-button @click="choose(row.item)" class="mr-2" size="xs">
                    This is me!
                </b-button>
            </template>

        </b-table>
    </div>

</template>

<script>
    export default {
        name: "SelectUser",

        data() {
            return {
                fields: ['id', 'forename', 'surname', 'me']
            }
        },

        props: {
            users: {
                type: Array,
                required: true
            }
        },

        methods: {
            choose(student) {
                this.$emit('selected', student);
            }
        }

    }
</script>

<style scoped>

</style>

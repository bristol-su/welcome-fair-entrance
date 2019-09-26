<template>
    <div>
        <b-table :fields="fields" :items="users">

            <template v-slot:cell(select)="row">
                <b-button @click="choose(row.item)" class="mr-2" size="xs">
                    This is me!
                </b-button>
            </template>

        </b-table>

        <b-button @click="$emit('reset')" variant="danger" class="restart">Restart</b-button>

    </div>

</template>

<script>
    export default {
        name: "SelectUser",

        data() {
            return {
                fields: ['id', 'forename', 'surname', 'select']
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
    .restart {
        width: 70%;
        margin: auto;
    }
</style>

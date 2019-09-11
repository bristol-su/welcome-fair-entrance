<template>
    <div>
        <b-table :style="{backgroundColor: backgroundColor}" :busy="busyState" :fields="fields" :items="results" striped>
            <template v-slot:table-busy>
                <div class="text-center text-danger my-2">
                    <b-spinner class="align-middle"></b-spinner>
                    <strong>Loading...</strong>
                </div>
            </template>




            <template v-slot:cell(entry)="row">
                <b-button @click="grantAccess(row.item.uid)" class="mr-2" size="xs" variant="success">
                    Grant Entry
                </b-button>
            </template>

            <template v-slot:row-details="row">
                <b-card style="text-align: left;">
                    <b-row>
                        <b-col xs="12" sm="6" lg="3">Age:</b-col>
                        <b-col xs="12" sm="6" lg="9">{{ age(row.item.dob) }} (DoB: {{dob(row.item.dob)}})</b-col>
                    </b-row>
                    <b-row>
                        <b-col xs="12" sm="6" lg="3">Alumni:</b-col>
                        <b-col xs="12" sm="6" lg="9">{{ (row.item.alumni === true ? 'Yes' : 'No') }}</b-col>
                    </b-row>
                    <b-row>
                        <b-col xs="12" sm="6" lg="3">Library Card:</b-col>
                        <b-col xs="12" sm="6" lg="9">{{ row.item.library_card }}</b-col>
                    </b-row>
                    <b-row>
                        <b-col xs="12" sm="6" lg="3">Programme:</b-col>
                        <b-col xs="12" sm="6" lg="9">{{ programme(row.item.programme) }}</b-col>
                    </b-row>
                </b-card>
            </template>
        </b-table>
    </div>
</template>

<script>
    import { differenceInYears, format } from 'date-fns'

    export default {
        name: "Table",


        props: {
            busyState: {
                type: Boolean,
                default: false
            },
            results: {
                type: Array,
                default: function () {
                    return [];
                }
            }
        },

        data() {
            return {
                fields: [
                    {key: 'uid', sortable: true},
                    {key: 'id', sortable: true},
                    {key: 'forename', sortable: true},
                    {key: 'surname', sortable: true},
                    {key: 'email', sortable: true},
                    {key: 'institution_email', sortable: true},
                    {key: 'show_details'},
                    {key: 'entry'}
                ],
                backgroundColor: 'white'
            }
        },

        methods: {
            grantAccess(uid) {
                this.$http.post('/api/uid', {uid: uid})
                    .then(response => {
                        this.backgroundColor = '#00cf64';
                        window.setTimeout(() => {
                            this.backgroundColor = 'white';
                        }, 1000)
                    })
                    .catch(error => console.log(error));
            },

            age(dob) {
                return differenceInYears(new Date(), new Date(dob));
            },

            dob(dob) {
                return format(new Date(dob), 'do MMM, yyyy')
            },

            programme(programme) {
                if(programme.length === 0) {
                    return 'No programme found';
                }
                return (programme[0].programme_name +
                    ' Level ' +
                    programme[0].programme_level +
                    ' until ' +
                    programme[0].end_date);
            }
        }
    }
</script>

<style scoped>
    /* Busy table styling */
    table.b-table[aria-busy='true'] {
        opacity: 0.6;
    }
</style>

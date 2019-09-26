<template>
    <div>

        <b-row>
            <b-col>
                <div class="header">Please now scan this QR code at the appropriate desk</div>
            </b-col>
        </b-row>

        <b-row>
            <b-col>
                <div v-if="!imageExists && !loading">
                    <b-button variant="warning" size="xs" @click="createQrCode()">Reload</b-button>
                </div>
                <div style="margin: auto;" :class="{bordered: !imageExists}" >
                    <img alt="Loading..." :src="'data:image/png;charset=utf-8;base64, ' + image" />
                </div>
            </b-col>
        </b-row>

        <b-row>
            <b-col>
                <strong>Name:</strong> {{forename}} {{surname}}
            </b-col>
        </b-row>
        <b-row>
            <b-col>
                <strong>DoB:</strong> {{formattedDob}} (age {{age}})
            </b-col>
        </b-row>


        <b-row>
            <b-col>
                <b-button variant="danger" @click="$emit('restart')" class="restart">Restart</b-button>
            </b-col>
        </b-row>
    </div>

</template>

<script>
    import {differenceInCalendarYears, format} from 'date-fns';
    export default {
        name: "QrCode",

        props: {
            forename: {
                type: String,
                required: true
            },
            surname: {
                type: String,
                required: true
            },
            uid: {
                type: Number,
                required: true
            },
            dob: {
                type: String,
                required: true
            }
        },

        data() {
            return {
                loading: false,
                image: null
            }
        },

        mounted() {
            this.createQrCode();
        },

        methods: {
            createQrCode() {
                this.loading = true;
                this.$http.post('/api/qrcode', {uid: this.uid})
                    .then(response => {
                        this.image = response.data
                    })
                    .catch(error => this.image = null)
                    .then(() => {
                        this.loading = false;
                    })
            },

        },

        computed: {
            imageExists() {
                return this.image !== null;
            },

            age() {
                return differenceInCalendarYears(new Date(), new Date(this.dob));
            },

            formattedDob() {
                return format(new Date(this.dob), 'dd/MM/y');
            }
        }

    }
</script>

<style scoped>
    .bordered {
        border: 1px solid black;
    }

    .restart {
        width: 70%;
        margin: auto;
    }

    .header {
        font-size: 1.1rem;
    }
</style>

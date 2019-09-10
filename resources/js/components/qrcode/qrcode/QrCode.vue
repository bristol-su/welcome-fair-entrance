<template>
    <div>
        <b-row>
            <b-col>
                Welcome {{student.forename}}!
            </b-col>
        </b-row>
        <b-row>
            <b-col>
                <strong>Name:</strong> {{student.forename}} {{student.surname}}!
            </b-col>
        </b-row>

        <b-row>
            <b-col>
                <div v-if="loading">Loading</div>
                <div v-else-if="!imageExists">Reload</div>
                <img alt="" :src="'data:image/png;charset=utf-8;base64, ' + image" />
            </b-col>
        </b-row>

    </div>

</template>

<script>
    export default {
        name: "QrCode",

        props: {
            student: {
                type: Object,
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
                this.$http.post('/', {uid: this.student.uid})
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
            }
        }

    }
</script>

<style scoped>

</style>

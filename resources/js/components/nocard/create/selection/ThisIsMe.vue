<template>
    <div>
        Hi {{student.forename}}! We're just generating your QR code.

        <div v-if="loading">Loading</div>
        <div v-else-if="!imageExists">Image not worked</div>
        <div v-else>
            <img alt="barcode" :src="'data:image/png;charset=utf-8;base64, ' + image" />
        </div>
    </div>

</template>

<script>
    export default {
        name: "ThisIsMe",

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
                this.$http.post('/no-card/student', {uid: this.student.uid})
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

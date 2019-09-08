<template>
    <div>
        <b-input type="text" v-model="cardNumber"></b-input>
        <b-button @click="upload" variant="secondary">Submit Card</b-button>
    </div>
</template>

<script>
    export default {
        name: "Scan",
        data() {
            return {
                cardNumber: null
            }
        },

        methods: {
            upload() {
                if(this.cardNumber !== null) {
                    this.$http.post('/api/scan', {
                        'card_number': this.cardNumber
                    })
                        .then(response => console.log(response))
                        .catch(error => console.log(error));
                }
            }
        }
    }
</script>

<style>

</style>

<template>
    <div :style="{backgroundColor: backgroundColor}">
        <b-form @submit.prevent="upload">
            <b-input type="text" v-model="cardNumber"></b-input>
            <b-button type="submit" variant="secondary">Submit Card</b-button>
        </b-form>
    </div>
</template>

<script>
    export default {
        name: "Scan",
        data() {
            return {
                cardNumber: null,
                backgroundColor: 'white'
            }
        },

        methods: {
            upload() {
                if(this.cardNumber !== null) {
                    this.$http.post('/api/scan', {
                        'card_number': this.cardNumber
                    })
                        .then(response => this.backgroundColor = '#00cf64')
                        .catch(error => this.backgroundColor = 'red')
                        .then(() => {
                            this.cardNumber = null;
                            window.setTimeout(() => {
                                this.backgroundColor = 'white'
                            }, 1000);
                        });
                }
            }
        }
    }
</script>

<style>

</style>

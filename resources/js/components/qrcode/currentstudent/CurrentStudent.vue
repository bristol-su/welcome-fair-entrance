<template>
    <b-row>
        <b-col>
            <b-button @click="$emit('input', true)" class="current-student">
                <b-row>
                    <b-col>
                        <h2>Current Student?</h2>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col>
                        Click here
                    </b-col>
                </b-row>
            </b-button>
        </b-col>
    </b-row>
</template>

<script>
    export default {
        name: "CurrentStudent",
    }
</script>

<style scoped>
    .current-student {
        color: #ffffff;
        background-color: #5eaeba;
        border: 0;
        width: 80%;
        height: 20vh;
    }
</style>

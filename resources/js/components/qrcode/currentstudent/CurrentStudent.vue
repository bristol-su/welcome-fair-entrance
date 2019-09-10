<template>
    <div>
        <b-row>
            <b-col>
                <h3>Are you a current student?</h3>
            </b-col>
        </b-row>
        <b-row>
            <b-col>
                <b-button-group>
                    <b-button @click="$emit('input', true)">Yes</b-button>
                    <b-button @click="$emit('input', false)">No</b-button>
                </b-button-group>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    export default {
        name: "CurrentStudent",
    }
</script>

<style scoped>

</style>

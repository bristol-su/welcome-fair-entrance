<template>
    <b-row>
        <b-col>
            <div class="header">Not a current student?</div>

            <div class="text">
                <div>
                    If you are a stallholder, you should proceed to the entrance.
                </div>
                <div>
                    If you are not a stallholder, you should talk to a member of staff in a blue Bristol SU t-shirt.
                </div>
            </div>
        </b-col>
    </b-row>
</template>

<script>
    export default {
        name: "NotCurrentStudent",
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

    .text {
        text-align: left;
        padding: 8px;
    }

    .header {
        font-size: 1.1rem;
    }
</style>

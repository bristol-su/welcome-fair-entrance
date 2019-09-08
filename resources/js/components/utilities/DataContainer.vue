<template>
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h3>{{title}}</h3>
        </div>

        <div class="content">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'DataContainer',

        props: {
            title: {
                required: true,
                type: String
            }
        }
    }
</script>

<style>

    .card {
        box-shadow: 0 2px 3px #cdd8df;
        border: none;
        margin-bottom: 20px;
    }

    .card > .card-header {
        padding-top: 0.7rem;
        padding-bottom: 0.7rem;
        background-color: #fff;
        border-bottom: none;
    }

</style>

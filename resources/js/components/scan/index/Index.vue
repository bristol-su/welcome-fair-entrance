<template>
    <div>
        <b-table :items="scanItems"></b-table>
    </div>
</template>

<script>
    export default {
        name: "Index",

        data() {
            return {
                perPage: 15,
                currentPage: 1,
                bottom: false
            }
        },

        created() {
            window.addEventListener('scroll', () => {
                this.bottom = this.bottomVisible()
            })
        },

        watch: {
            bottom(bottom) {
                if (bottom) {
                    this.currentPage++;
                }
            }
        },

        methods: {
            bottomVisible() {
                const scrollY = window.scrollY;
                const visible = document.documentElement.clientHeight;
                const pageHeight = document.documentElement.scrollHeight;
                const bottomOfPage = visible + scrollY >= pageHeight;
                return bottomOfPage || pageHeight < visible;
            },
        },

        computed: {
            scanItems() {
                return this.$store.getters.scansMostRecent.slice(0, this.maxElement);
            },

            maxElement() {
                return this.currentPage * this.perPage;
            }
        },
    }
</script>

<style>

</style>

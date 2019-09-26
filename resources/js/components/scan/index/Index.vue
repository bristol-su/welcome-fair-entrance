<template>
    <div>
        <b-table :items="scanItems"></b-table>
    </div>
</template>

<script>

    import {format} from 'date-fns';

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

            toHumanDate(unix) {
                return format(new Date(unix*1000), 'dd/MM/yy HH:mm:ss');
            }
        },

        computed: {
            scanItems() {
                return this.$store.getters.scansMostRecent.slice(0, this.maxElement).map(scan => {
                    return {
                        committee_member: scan.committee_member,
                        department: scan.department,
                        study_type: scan.study_type,
                        programme_year: scan.programme_year,
                        age: scan.age,
                        gender: scan.gender,
                        scanned_at: this.toHumanDate(scan.scanned_at)
                    }
                });
            },

            maxElement() {
                return this.currentPage * this.perPage;
            }
        },
    }
</script>

<style>

</style>

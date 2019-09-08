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
                scan: []
            }
        },

        created() {
            this.$echo.channel('welcome-fair')
                .listen('ScanUpdated', (event) => {
                    this.replaceScan(event.scan);
                })
                .listen('ScanCreated', (event) => {
                    this.appendScan(event.scan);
                });
            this.getScans();

        },

        methods: {
            getScans() {
                this.$http.get('/api/scan')
                    .then(response => {
                        response.data.forEach(scan => this.appendScan(scan));
                    })
                    .catch(error => console.log(error));
            },

            appendScan(scan) {
                this.scan.push(scan);
            },

            replaceScan(scan) {
                this.scan.splice(this.scan.map(scanMap => scanMap.id).indexOf(scan.id), 1, scan);
            },
        },

        computed: {
            scanItems() {
                return this.scan.sort((a, b) => (b.id - a.id));
            }
        }
    }
</script>

<style>

</style>

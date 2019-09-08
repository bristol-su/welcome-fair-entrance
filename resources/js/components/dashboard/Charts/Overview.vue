<template>

    <data-container title="Overview">

        <div class="card-bg-secondary">
            <div class="d-flex">
                <div class="w-25 border-right border-bottom">
                    <div class="p-4">
                        <small class="text-uppercase">Total Scans</small>

                        <h4 class="mt-4 mb-0">
                            {{ scanCount }}
                        </h4>
                    </div>
                </div>

                <div class="w-25 border-right border-bottom">
                    <div class="p-4">
                        <small class="text-uppercase">Scans Processed</small>

                        <h4 class="mt-4 mb-0">
                            {{processedCount}}
                        </h4>
                    </div>
                </div>

                <div class="w-25 border-right border-bottom">
                    <div class="p-4">
                        <small class="text-uppercase">Committee Members</small>

                        <h4 class="mt-4 mb-0">
                            {{committeeMembers}}
                        </h4>
                    </div>
                </div>

                <div class="w-25 border-right border-bottom">
                    <div class="p-4">
                        <small class="text-uppercase">Non-Committee Members</small>

                        <h4 class="mt-4 mb-0">
                            {{scanCount - committeeMembers}}
                        </h4>
                    </div>
                </div>

            </div>

        </div>
    </data-container>
</template>

<script>
    import DataContainer from "../../utilities/DataContainer";

    export default {

        components: {
            DataContainer
        },

        computed: {
            scanCount() {
                return this.$store.getters.scans.length;
            },

            processedCount() {
                return this.$store.getters.scans.filter(scan => {
                    return scan.committee_member !== null && scan.study_type !== null;
                }).length;
            },

            committeeMembers() {
                return this.$store.getters.scans.filter(scan => scan.committee_member === true).length;
            }
        }
    }
</script>

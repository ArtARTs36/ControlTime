<template>
    <mdb-container>
        <mdb-row>
            <mdb-col col="sm">
                <home-block-push-info></home-block-push-info>
            </mdb-col>
        </mdb-row>

        <mdb-row>
            <br/>
        </mdb-row>

        <mdb-row>
            <mdb-col col="sm">
                <home-block-workers></home-block-workers>
            </mdb-col>
            <mdb-col col="sm">
                <home-block-control-times></home-block-control-times>
            </mdb-col>
        </mdb-row>
    </mdb-container>
</template>

<script>
    import {mdbContainer, mdbRow, mdbCol} from 'mdbvue';
    import HomeBlockWorkers from "@/components/HomeBlockWorkers";
    import HomeBlockControlTimes from "@/components/HomeBlockControlTimes";
    import HomeBlockPushInfo from "@/components/HomeBlockPushInfo";

    export default {
        components: {
            mdbContainer,
            mdbRow,
            mdbCol,
            HomeBlockWorkers,
            HomeBlockControlTimes,
            HomeBlockPushInfo,
        },

        created() {
            document.title = 'ControlTime';
        }
    }
</script>

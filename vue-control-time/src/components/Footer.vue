<template>
    <mdb-footer color="stylish-color-dark" class="page-footer font-small">
        <div class="footer-copyright text-center py-3 stylish-color-dark">
            <mdb-container fluid>
                &copy; 2020 Copyright Artem Ukrainsky
            </mdb-container>
        </div>
    </mdb-footer>
</template>

<script>
    import { mdbFooter, mdbContainer, mdbRow, mdbCol } from 'mdbvue';
    export default {
        name: 'FooterPage',
        components: {
            mdbFooter,
            mdbContainer,
            mdbRow,
            mdbCol
        }
    }
</script>

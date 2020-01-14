<template>
    <mdb-pagination circle v-on:click="openPage">
        <div @click="openFirstPage">
            <mdb-page-item v-bind:disabled="currentPage === 1">First</mdb-page-item>
        </div>

        <div @click="openBackPage">
            <mdb-page-nav prev v-bind:disabled="currentPage === 1"></mdb-page-nav>
        </div>

        <div v-for="number in genArrayByNumbers(startViewPage, endViewPage)" @click="openPage(number)">
            <mdb-page-item v-bind:active="currentPage === number">
                {{ number }}
            </mdb-page-item>
        </div>

        <div @click="openNextPage">
            <mdb-page-nav next v-bind:disabled="currentPage === totalPages"></mdb-page-nav>
        </div>

        <mdb-page-item v-bind:disabled="currentPage === totalPages">
            <span @click="openLastPage">Last</span>
        </mdb-page-item>
    </mdb-pagination>
</template>

<script>
    import { mdbPagination, mdbPageItem, mdbPageNav } from 'mdbvue';
    import loader from '../router/loader'
    export default {
        name: 'Pagination',
        components: {
            mdbPagination,
            mdbPageItem,
            mdbPageNav
        },

        props: [
            'totalCount'
        ],

        data() {
            return {
                currentPage: 1,
                countEntriesForOnePage: 10,
                totalPages: 0,
                countViewPages: 10,
                startViewPage: 1,
                endViewPage: 10
            };
        },

        mounted() {
              this.endViewPage = this.countViewPages;
        },

        methods: {
            openPage(number) {
                if (number > this.totalPages) {
                    return false;
                }

                this.currentPage = number;

                this.refreshPages();

                this.$emit('openPage', number);
            },
            openNextPage() {
                if (this.currentPage === this.totalPages) {
                    return false;

                }

                this.$emit('openPage', ++this.currentPage);

                this.refreshPages();
            },
            openLastPage() {
                if (this.currentPage === this.totalPages) {
                    return false;
                }

                this.currentPage = this.totalPages;

                this.refreshPages();

                this.$emit('openPage', this.currentPage);
            },
            openFirstPage() {
                if (this.currentPage === 1) {
                    return false;
                }

                this.currentPage = 1;

                this.refreshPages();

                this.$emit('openPage', 0);
            },
            openBackPage() {
                if (this.currentPage === 1) {
                    return false;
                }

                this.currentPage--;

                this.refreshPages();

                this.openPage(this.currentPage);
            },
            refreshPages() {
                if (this.countViewPages > this.totalPages) {
                    return false;
                }

                loader.loaderByPagination();

                if (this.currentPage === 1) {
                    this.startViewPage = 1;
                    this.endViewPage = this.countViewPages;

                    return true;
                }

                let middle = Math.round(this.countViewPages / 2);

                if (this.currentPage - middle > 0) {
                    this.startViewPage = this.currentPage - middle;
                } else {
                    this.startViewPage = 1;
                }

                if (this.currentPage + middle >= this.totalPages) {
                    this.startViewPage = this.totalPages - this.countViewPages;
                    this.endViewPage = this.totalPages;
                } else if (this.currentPage - middle > 0) {
                    this.endViewPage = this.currentPage + middle;
                }

                if (this.startViewPage === 0) {
                    this.startViewPage = 1;
                }
            },
            genArrayByNumbers(start, end) {
                let arr = [];
                for (let i = start; i < end + 1; i++) {
                    arr.push(i);
                }

                return arr;
            }
        },

        created() {
            this.totalPages = Math.floor(this.totalCount / this.countEntriesForOnePage);
            if (this.totalCount % this.countEntriesForOnePage !== 0) {
                this.totalPages++;
            }

            if (this.totalPages < 10) {
                this.countViewPages = this.totalPages;
            }
        }
    }
</script>

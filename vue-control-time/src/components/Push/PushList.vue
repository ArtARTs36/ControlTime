<template>
    <mdb-card>
        <mdb-card-body>
            <mdb-card-title>Список отправленных уведомлений</mdb-card-title>
            <mdb-card-text>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Заголовок</th>
                            <th scope="col">Сообщение</th>
                            <th scope="col">Дата отправки</th>
                        </tr>
                        </thead>
                        <tr v-for="item in pushes">
                            <td scope="row">{{ item.id }}</td>
                            <td scope="row">{{ item.title }}</td>
                            <td scope="row">{{ item.message }}</td>
                            <td scope="row">{{ item.created_at }}</td>
                        </tr>
                    </table>
                </div>
            </mdb-card-text>

            <Pagination v-bind:totalCount="totalCount" @openPage="loadPushes" v-if="isLoadEntries"/>
        </mdb-card-body>
    </mdb-card>
</template>

<script>
    import { mdbCard, mdbCardImage, mdbCardBody, mdbCardTitle, mdbCardText, mdbBtn, mdbBadge } from 'mdbvue';
    import axios from 'axios';
    import Pagination from '@/components/Pagination';
    export default {
        data() {
            return {
                pushes: [],
                error: null,
                totalCount: null,
                maxCountEntriesForOnePage: 10,
                isLoadEntries: false,
                currentOffset: 0,
                currentPage: 1,
            }
        },

        components: {
            mdbCard,
            mdbCardImage,
            mdbCardBody,
            mdbCardTitle,
            mdbCardText,
            mdbBtn,
            Pagination,
            mdbBadge
        },

        created() {
            this.loadPushes(1);

            document.title = 'Список уведомлений';
        },

        methods: {
            loadPushes(page) {
                if (page === undefined) {
                    page = this.currentPage;
                }

                let URL = API_URL + '/pushes/page-' + page;

                axios.get(URL)
                    .then(response => {
                        this.pushes = response.data.data;
                        this.totalCount = response.data.total;
                        this.isLoadEntries = true;

                        this.currentPage = page;
                    })
                    .catch(e => {
                        this.error=e;
                    });
            },
        }
    }
</script>

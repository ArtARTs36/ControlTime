<template>
    <mdb-card>
        <mdb-card-body>
            <mdb-card-title>Список посещений</mdb-card-title>
            <select class="browser-default custom-select" @change="changeSort" v-model="sortType">
                <option v-for="sort in sortVars" :value="sort.prepare">{{ sort.description }}</option>
            </select>
            <mdb-card-text>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Сотрудник</th>
                        <th scope="col">Дата</th>
                        <th scope="col">Приход</th>
                        <th scope="col">Уход</th>
                    </tr>
                    </thead>
                    <tr v-for="item in times">
                        <td>{{ item.id }}</td>
                        <td>{{ item.worker.family}} {{ item.worker.name }}</td>
                        <td>{{ item.start_date | renderDate }}</td>
                        <td>{{ item.start_date | renderTime }}</td>
                        <td>{{ item.end_date | renderTime }}</td>
                    </tr>
                </table>
            </mdb-card-text>

            <Pagination v-bind:totalCount="totalCount" @openPage="refreshTimes" v-if="isLoadEntries"/>
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
                times: [],
                error: null,
                totalCount: null,
                maxCountEntriesForOnePage: 10,
                isLoadEntries: false,
                currentOffset: 0,
                currentPage: 1,
                sortVars: [
                    {
                        'prepare': 'id-asc',
                        'description': 'Сортировать по'
                    },
                    {
                        'prepare': 'id-desc',
                        'description': 'Сортировать по ID записи (убывание)'
                    },
                    {
                        'prepare': 'id-asc',
                        'description': 'Сортировать по ID записи (возрастание)'
                    },
                    {
                        'prepare': 'date-desc',
                        'description': 'Сортировать по дате (убывание)'
                    },
                    {
                        'prepare': 'date-asc',
                        'description': 'Сортировать по дате (возрастание)'
                    },
                    {
                        'prepare': 'worker-asc',
                        'description': 'Сортировать по сотруднику (возрастание)'
                    },
                    {
                        'prepare': 'worker-desc',
                        'description': 'Сортировать по сотруднику (убывание)'
                    }
                ],
                sortType: 'id-desc'
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
            this.loadTimes(1);

            document.title = 'Список посещений';
        },

        methods: {
            loadTimes(page) {
                if (page === undefined) {
                    page = this.currentPage;
                }

                const URL = API_URL + '/times/page-' + page + '/sort/' + this.sortType;

                axios.get(URL)
                    .then(response => {
                        this.times = response.data.data;
                        this.totalCount = response.data.total;
                        this.isLoadEntries = true;

                        this.currentPage = page;
                    })
                    .catch(e => {
                        this.error=e;
                    });
            },
            refreshTimes(page) {
                this.loadTimes(page);
            },
            changeSort() {
                this.loadTimes();
            }
        }
    }
</script>

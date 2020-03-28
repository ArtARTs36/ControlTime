<template>
    <mdb-card>
        <mdb-card-body>
            <mdb-card-title v-if="!workerId">Список посещений</mdb-card-title>
            <mdb-card-title v-else>
                Список посещений сотрудника {{ times[0].worker.name }} {{ times[0].worker.family }}
            </mdb-card-title>
            <select class="browser-default custom-select" @change="changeSort" v-model="sortType">
                <option v-for="sort in sortVars" :value="sort.prepare">{{ sort.description }}</option>
            </select>
            <mdb-card-text>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col" v-if="!workerId">Сотрудник</th>
                            <th scope="col">Дата прихода</th>
                            <th scope="col">Время прихода</th>
                            <th scope="col">Дата ухода</th>
                            <th scope="col">Время ухода</th>
                        </tr>
                        </thead>
                        <tr v-for="item in times">
                            <td scope="row">{{ item.time_id }}</td>
                            <td scope="row" v-if="!workerId">
                                <router-link :to="{ name: 'workerEdit', params: { id: item.worker.id }}">
                                    {{ item.worker.family}} {{ item.worker.name }}
                                </router-link>

                                <router-link :to="{ name: 'timeListByWorker', params: { workerId: item.worker.id }}">
                                    <i class="far fa-calendar-alt" title="Посмотреть всю посещаемость сотрудника"></i>
                                </router-link>
                            </td>
                            <td scope="row">{{ item.start_date }} ({{ item.start_date | dayOfWeek }})</td>
                            <td scope="row">{{ item.start_time}}</td>
                            <td scope="row">{{ item.end_date }} ({{ item.end_date | dayOfWeek }})</td>
                            <td scope="row">{{ item.end_time }}</td>
                        </tr>
                    </table>
                </div>
            </mdb-card-text>

            <router-link :to="{ name: 'timeList' }" v-if="workerId > 0">
                <mdb-btn style="width:100%" color="primary">
                    Открыть посещаемость всех сотрудников
                </mdb-btn>
            </router-link>

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
            let workerId = this.$route.params.workerId;

            let sortVars = [
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
                }
            ];

            if (!workerId) {
                sortVars.push(
                    {
                        'prepare': 'worker-asc',
                        'description': 'Сортировать по сотруднику (возрастание)'
                    },
                    {
                        'prepare': 'worker-desc',
                        'description': 'Сортировать по сотруднику (убывание)'
                    }
                );
            }

            return {
                times: [],
                error: null,
                totalCount: null,
                maxCountEntriesForOnePage: 10,
                isLoadEntries: false,
                currentOffset: 0,
                currentPage: 1,
                sortVars,
                sortType: 'date-desc',
                workerId
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

                let URL = API_URL + '/times/page-' + page + '/sort/' + this.sortType + '/count-'
                    + this.maxCountEntriesForOnePage;

                if (this.$route.params.workerId > 0) {
                    URL += '/workerId-' + this.workerId;
                }

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

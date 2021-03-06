<template>
    <mdb-card>
        <mdb-card-body>
            <mdb-card-title>Список сотрудников</mdb-card-title>
            <mdb-card-text>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Фамилия</th>
                            <th scope="col">Имя</th>
                            <th scope="col">Отчество</th>
                            <th scope="col">Телефон</th>
                            <th scope="col">Дата принятия на работу</th>
                            <th scope="col">Стаж</th>
                            <th scope="col">Действия</th>
                        </tr>
                        </thead>
                        <tr v-for="item in workers">
                            <td scope="row">{{ item.id }}</td>
                            <td scope="row">{{ item.family }}</td>
                            <td scope="row">{{ item.name }}</td>
                            <td scope="row">{{ item.patronymic }}</td>
                            <td scope="row">
                                <span v-if="item.phone">{{ item.phone | renderPhone }}</span>
                                <mdb-badge color="danger" v-else>не указан</mdb-badge>
                            </td>
                            <td scope="row">
                                {{ item.hired_date | dateTime }}
                            </td>
                            <td scope="row">
                                {{ item.hired_date | renderExperience}}
                            </td>
                            <td scope="row">
                                <router-link :to="{ name: 'timeListByWorker', params: { workerId: item.id }}">
                                    <i class="far fa-calendar-alt" title="Посмотреть посещаемость"></i>
                                </router-link>

                                <router-link :to="{ name: 'workerVacationApplication', params: { workerId: item.id }}">
                                    <i class="fas fa-plane ml-2" title="Создать заявление на отпуск"></i>
                                </router-link>

                                <a @click="downloadReport(item.id)">
                                    <i class="fas fa-download ml-2" title="Скачать отчет о посещаемости"></i>
                                </a>

                                <router-link :to="{ name: 'timeCreate', params: { workerId: item.id }}">
                                    <i class="fas fa-plus ml-2" title="Добавить отметку о посещении"></i>
                                </router-link>

                                <a class="far fa-trash-alt ml-2" @click="removeWorker(item.id)" title="Удалить сотрудника"></a>

                                <router-link :to="{ name: 'workerEdit', params: { id: item.id }}">
                                    <i class="far fa-edit ml-2" title="Редактировать"></i>
                                </router-link>
                            </td>
                        </tr>
                    </table>
                </div>
            </mdb-card-text>

            <Pagination v-bind:totalCount="totalCount" @openPage="refreshWorkers" v-if="isLoadEntries"/>
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
                workers: [],
                error: null,
                totalCount: null,
                maxCountEntriesForOnePage: 10,
                isLoadEntries: false,
                currentOffset: 0,
                currentPage: 1
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
            this.loadWorkers(1);

            document.title = 'Список сотрудников';
        },

        methods: {
            downloadReport(workerId) {
                window.location.href = API_URL + '/times/report/worker/' + workerId;
            },
            loadWorkers(page) {
                if (page === undefined) {
                    page = this.currentPage;
                }

                const URL = API_URL + '/workers/page-' + page + '/sort/id-asc';

                axios.get(URL)
                    .then(response => {
                        this.workers = response.data.data;
                        this.totalCount = response.data.total;
                        this.isLoadEntries = true;

                        this.currentPage = page;
                    })
                    .catch(e => {
                        this.error=e;
                    });
            },
            refreshWorkers(page) {
                this.loadWorkers(page);
            },
            removeWorker(id) {
                axios.delete(API_URL + '/workers/' + id)
                    .then(response => {
                        this.refreshWorkers();
                    })
                    .catch(e => {
                        this.error=e;
                    });
            }
        }
    }
</script>

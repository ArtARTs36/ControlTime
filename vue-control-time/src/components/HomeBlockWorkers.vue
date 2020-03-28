<template>
    <mdb-card>
        <mdb-card-body>
            <mdb-card-title>Сотрудники</mdb-card-title>
            <mdb-card-text>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Фамилия</th>
                            <th scope="col">Имя</th>
                            <th scope="col">Действия</th>
                        </tr>
                        </thead>
                        <tr v-for="item in workers">
                            <td scope="row">{{ item.family }}</td>
                            <td scope="row">{{ item.name }}</td>
                            <td scope="row">
                                <router-link :to="{ name: 'workerEdit', params: { id: item.id }}">
                                    <i class="far fa-edit ml-2" title="Редактировать"></i>
                                </router-link>
                            </td>
                        </tr>
                    </table>
                </div>
            </mdb-card-text>
            <router-link to="/workers/all">
                <mdb-btn color="primary">Открыть список всех сотрудников</mdb-btn>
            </router-link>
        </mdb-card-body>
    </mdb-card>
</template>

<script>
    import { mdbCard, mdbCardImage, mdbCardBody, mdbCardTitle, mdbCardText, mdbBtn } from 'mdbvue';
    import axios from 'axios';
    export default {
        name: 'CardPage',
        components: {
            mdbCard,
            mdbCardImage,
            mdbCardBody,
            mdbCardTitle,
            mdbCardText,
            mdbBtn
        },

        data() {
            return {
                workers: [],
                error: null
            }
        },

        created() {
            axios.get(API_URL + '/workers/page-1/sort/id-asc/count-7')
                .then(response => {
                    this.workers = response.data.data;
                })
                .catch(e => {
                    this.error = e;
                })
        }
    }
</script>

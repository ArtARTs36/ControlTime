<template>
    <mdb-card>
        <mdb-card-body>
            <mdb-card-title>Посещения</mdb-card-title>
            <mdb-card-text>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Сотрудник</th>
                                <th scope="col">Дата</th>
                                <th scope="col">Время прихода</th>
                                <th scope="col">Время ухода</th>
                            </tr>
                        </thead>
                        <tr v-for="item in times">
                            <td scope="row">{{ item.worker.family }} {{ item.worker.name }}</td>
                            <td scope="row">{{ item.start_date | dateOnlyDmy }}</td>
                            <td scope="row">{{ item.start_time | formatTime }}</td>
                            <td scope="row">{{ item.end_time | formatTime }}</td>
                        </tr>
                    </table>
                </div>
            </mdb-card-text>
            <router-link to="/times/all">
                <mdb-btn color="primary">Открыть список всех посещений</mdb-btn>
            </router-link>
        </mdb-card-body>
    </mdb-card>
</template>

<script>
    import { mdbCard, mdbCardImage, mdbCardBody, mdbCardTitle, mdbCardText, mdbBtn } from 'mdbvue';
    import axios from 'axios';
    export default {
        name: 'HomeBlockControlTimes',
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
                times: [],
                error: null
            }
        },

        methods: {
            loadTimes() {
                const URL = API_URL + '/times/page-1/sort/id-desc/count-7';

                axios.get(URL)
                    .then(response => {
                        this.times = response.data.data;
                    })
                    .catch(e => {
                        this.error=e;
                    });
            }
        },

        created() {
            this.loadTimes();
        }
    }
</script>

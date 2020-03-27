<template>
    <mdb-card>
        <mdb-card-body>
            <mdb-card-title>Посещения</mdb-card-title>
            <mdb-card-text>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Сотрудник</th>
                            <th>Дата</th>
                            <th>Время прихода</th>
                            <th>Время ухода</th>
                        </tr>
                    </thead>
                    <tr v-for="item in times">
                        <td>{{ item.worker.family }} {{ item.worker.name }}</td>
                        <td>{{ item.start_date | dateOnlyMd }}</td>
                        <td>{{ item.start_time }}</td>
                        <td>{{ item.end_time }}</td>
                    </tr>
                </table>
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

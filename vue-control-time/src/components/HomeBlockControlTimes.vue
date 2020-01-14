<template>
    <mdb-card>
        <mdb-card-body>
            <mdb-card-title>Посещения</mdb-card-title>
            <mdb-card-text>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Сотрудник</th>
                            <th>Дата прихода</th>
                            <th>Дата ухода</th>
                        </tr>
                    </thead>
                    <tr v-for="item in times">
                        <td>{{ item.worker.family }} {{ item.worker.name }}</td>
                        <td>{{ item.start_date }}</td>
                        <td>{{ item.end_date }}</td>
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

        created() {
        }
    }
</script>

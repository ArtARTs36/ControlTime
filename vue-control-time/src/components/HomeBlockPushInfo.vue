<template>
    <mdb-card>
        <mdb-card-body>
            <mdb-card-title>PUSH-Уведомления</mdb-card-title>
            <mdb-card-text v-if="pushesCount > 0">
                <mdb-input label="Количество отправленных уведомлений" v-model="this.pushesCount" disabled />
                <mdb-input label="Последнее было отправлено в" v-model="this.lastDate" disabled />
            </mdb-card-text>

            <a :href="this.followLink">
                <mdb-btn color="primary">Подписаться на канал для получения уведомлений</mdb-btn>
            </a>
        </mdb-card-body>
    </mdb-card>
</template>

<script>
    import { mdbCard, mdbCardImage, mdbCardBody, mdbCardTitle, mdbCardText, mdbBtn, mdbInput } from 'mdbvue';
    import axios from 'axios';
    export default {
        name: 'HomeBlockPushInfo',
        components: {
            mdbCard,
            mdbCardImage,
            mdbCardBody,
            mdbCardTitle,
            mdbCardText,
            mdbBtn,
            mdbInput,
        },

        data() {
            return {
                followLink: null,
                pushesCount: null,
                lastDate: null,
            }
        },

        methods: {
            loadInfo() {
                const URL = API_URL + '/pushes/info';

                axios.get(URL)
                    .then(response => {
                        this.followLink = response.data.followLink;
                        this.pushesCount = response.data.pushesCount;
                        this.lastDate = response.data.lastDate;
                    })
                    .catch(e => {
                        this.error=e;
                    });
            }
        },

        created() {
            this.loadInfo();
        }
    }
</script>

<template>
    <mdb-card>
        <mdb-card-body>
            <mdb-card-title>
                Отправить всем сотрудникам уведомления
            </mdb-card-title>

            <form @submit="checkForm">
                <mdb-card-text>
                    <mdb-input label="Заголовок" v-model="push.title" />
                    <mdb-input label="Сообщение" v-model="push.message" />
                </mdb-card-text>
                <mdb-btn style="width:100%" color="default">Сохранить</mdb-btn>
            </form>
            <router-link v-bind:to="linkList">
                <mdb-btn style="width:100%" color="primary">Открыть список отправленных уведомлений</mdb-btn>
            </router-link>
        </mdb-card-body>

        <ModalResult v-if="isOpenModalResult" v-bind:result="resultSave" v-bind:form-errors="formErrors"
                     @closeModal="closeModalResult" v-bind:back-link=linkList />
    </mdb-card>
</template>

<script>
    import { mdbCard, mdbCardImage, mdbCardBody, mdbCardTitle, mdbCardText, mdbBtn, mdbInput} from 'mdbvue';
    import axios from 'axios';
    import ModalResult from "../ModalResult";
    import 'vue-mdl-datepicker/dist/vue-mdl-datepicker.css';
    import MdlDatepicker from 'vue-mdl-datepicker';
    import TimeSelector from 'vue-timeselector';

    export default {
        components: {
            mdbCard,
            mdbCardImage,
            mdbCardBody,
            mdbCardTitle,
            mdbCardText,
            mdbBtn,
            mdbInput,
            ModalResult,
            MdlDatepicker,
            TimeSelector
        },

        data() {
            const blankPush = {
                title: null,
                message: null,
            };

            return {
                error: null,
                isOpenModalResult: false,
                resultSave: null,
                formErrors: [],
                linkList: '/pushes/all',
                push: blankPush,
            }
        },

        methods: {
            save() {
                this.resultSave = null;

                axios.post(API_URL + '/pushes/', this.push)
                    .then((response) => {
                        this.resultSave = (response.data.success) ? 'Данные успешно сохранены!' : response.data.message;
                    })
                    .catch((error) => {
                        this.resultSave = error;
                    })
                    .finally(() => (this.isOpenModalResult = true));
            },
            checkForm(e) {
                this.formErrors = [];
                this.resultSave = '';

                e.preventDefault();

                if (!(this.push.title)) {
                    this.formErrors.push('Не указан заголовок');
                }

                if (!(this.push.message)) {
                    this.formErrors.push('Не указано сообщение');
                }

                if (!this.formErrors.length) {
                    this.save();
                } else {
                    this.isOpenModalResult = true;
                }

                e.preventDefault();
            },
            closeModalResult() {
                this.isOpenModalResult = false;
            },
        },

        created() {
            document.title = 'Отправить всем сотрудникам уведомления';
            this.loadWorker();
        }
    }
</script>

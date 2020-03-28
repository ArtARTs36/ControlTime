<template>
    <mdb-card>
        <mdb-card-body>
            <mdb-card-title>Сотрудник: {{ worker.name }} {{ worker.family }}</mdb-card-title>

            <form @submit="checkForm">
                <mdb-card-text>
                    <mdb-input label="Имя" v-model="worker.name" />
                    <mdb-input label="Отчество" v-model="worker.patronymic" />
                    <mdb-input label="Фамилия" v-model="worker.family" />
                    <mdb-input label="Номер телефона" v-model="worker.phone" />
                </mdb-card-text>
                <mdb-btn style="width:100%" color="default">Сохранить</mdb-btn>
            </form>
            <router-link v-bind:to="linkList">
                <mdb-btn style="width:100%" color="primary">Открыть список сотрудников</mdb-btn>
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
    export default {
        components: {
            mdbCard,
            mdbCardImage,
            mdbCardBody,
            mdbCardTitle,
            mdbCardText,
            mdbBtn,
            mdbInput,
            ModalResult
        },

        data() {
            const blankWorker = {
                id: 0,
                firstName: null,
                patronymic: null,
                family: null,
                phone: null
            };

            return {
                error: null,
                isOpenModalResult: false,
                resultSave: null,
                formErrors: [],
                linkList: '/workers/all',
                workerId: this.$route.params.id,
                worker: blankWorker,
                typeAction: (this.$route.params.id > 0) ? 'put' : 'post'
            }
        },

        methods: {
            save() {
                this.resultSave = null;

                const options = {
                    'entryData': this.worker
                };

                let request;
                if (this.typeAction === 'put') {
                    request = axios.put(API_URL + '/workers/' + this.workerId, options);
                } else {
                    request = axios.post(API_URL + '/workers/', options);
                }

                request.then((response) => {
                    if (response.data.success) {
                        this.resultSave = 'Данные успешно сохранены!';
                        this.worker = response.data.entryData;
                    } else {
                        this.resultSave = response.data.message;
                    }
                })
                .catch((error) => {
                    this.resultSave = error;
                })
                .finally(() => (this.isOpenModalResult = true));
            },
            loadWorker() {
                axios.get(API_URL + '/workers/' + this.workerId)
                    .then(response => {
                        this.worker = response.data;
                    })
                    .catch(e => {
                        this.error = e;
                    }).finally(() => (document.title = 'Сотрудник: ' + this.worker.name + ' ' + this.worker.family));
            },
            checkForm(e) {
                e.preventDefault();
                this.formErrors = [];
                this.resultSave = '';

                if (!this.worker.name) {
                    this.formErrors.push('Не указано имя');
                }

                if (!this.worker.patronymic) {
                    this.formErrors.push('Не указано отчество');
                }

                if (!this.worker.family) {
                    this.formErrors.push('Не указана фамилия');
                }

                if (!this.isValidPhone()) {
                    this.formErrors.push('Не корректно указан номер');
                }

                if (!this.formErrors.length) {
                    this.save();
                } else {
                    this.isOpenModalResult = true;
                }

                e.preventDefault();
            },
            isValidPhone() {
                if (!this.worker.phone || this.worker.phone.length !== 11) {
                    return false;
                }

                let intPhone = parseInt(this.worker.phone);
                if (this.worker.phone != intPhone) {
                    return false;
                }

                return true;
            },
            closeModalResult() {
                this.isOpenModalResult = false;
            }
        },
        created() {
            if (this.workerId > 0) {
                this.loadWorker();
            } {
                document.title = 'Добавить сотрудника';
            }
        }
    }
</script>

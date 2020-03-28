<template>
    <mdb-card>
        <mdb-card-body>
            <mdb-card-title>Создать заявление на отпуск для сотрудника:
                {{ worker.name }} {{ worker.family }}
            </mdb-card-title>

            <form @submit="checkForm">
                <mdb-card-text>
                    <div class="form-group">
                        <select class="browser-default custom-select" v-model="application.type">
                            <option v-for="type in vacationTypes" :value="type.prepare">{{ type.description }}</option>
                        </select>
                    </div>

                    <mdb-input label="Количество календарных дней" v-model="application.days" />

                    <div class="form-group">
                        Дата ухода в отпуск
                        <mdl-datepicker
                            v-bind:minDate="currentDate"
                            orientation="landscape"
                            v-model="application.vacationDate"
                            :default="application.vacationDate"
                        ></mdl-datepicker>
                    </div>

                </mdb-card-text>
                <mdb-btn style="width:100%" color="default">Сохранить</mdb-btn>
            </form>
            <router-link :to="{name: 'workerList'}">
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
            let vacationTypes = [
                {
                    'prepare': 1,
                    'description': 'Ежегодный оплачиваемый отпуск'
                },
                {
                    'prepare': 2,
                    'description': 'Ежегодный оплачиваемый отпуск с последующим увольнением'
                },
                {
                    'prepare': 3,
                    'description': 'Отпуск без сохранения заработной платы'
                },
            ];

            const application = {
                vacationDate: new Date(),
                type: 1,
                days: 14,
            };

            let currentDate = new Date();

            return {
                error: null,
                isOpenModalResult: false,
                resultSave: null,
                formErrors: [],
                linkList: '/workers/all',
                workerId: this.$route.params.workerId,
                worker: null,
                application,
                lang: {
                    formatLocale: {
                        firstDayOfWeek: 1,
                    },
                    monthBeforeYear: false
                },
                disableYearSelection: false,
                vacationTypes,
                currentDate,
            }
        },

        methods: {
            save() {
                this.resultSave = null;

                const URL = API_URL + '/workers/' + this.workerId + '/load/vacation-application';

                axios.post(URL, this.application)
                    .then((response) => {
                        window.location.href = API_URL + '/document-download/' + response.data.fileName;
                    })
                    .catch((error) => {
                        this.resultSave = error;
                        this.isOpenModalResult = true
                    });
            },
            loadWorker() {
                axios.get(API_URL + '/workers/' + this.workerId)
                    .then(response => {
                        this.worker = response.data;
                    })
                    .catch(e => {
                        this.error = e;
                    })
            },
            checkForm(e) {
                this.formErrors = [];
                this.resultSave = '';

                e.preventDefault();

                if (!(this.worker.id > 0)) {
                    this.formErrors.push('Не указан сотрудник');
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
            document.title = 'Создать заявление на отпуск';
            this.loadWorker();
        }
    }
</script>

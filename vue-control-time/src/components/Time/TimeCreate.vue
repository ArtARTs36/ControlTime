<template>
    <mdb-card v-if="workerId > 0">
        <mdb-card-body>
            <mdb-card-title>Внести отметку о посещении сотрудника:
                {{ worker.name }} {{ worker.family }}
            </mdb-card-title>

            <form @submit="checkForm">
                <mdb-card-text>
                    <div class="form-group">
                        Дата
                        <mdl-datepicker
                            v-bind:minDate="new Date(worker.hired_date)"
                            v-bind:disableYearSelection
                                ="new Date(worker.hired_date).getFullYear() === new Date().getFullYear()"
                            v-bind:maxDate="new Date()"
                            orientation="landscape"
                            v-model="time.date"
                            :default="time.date"
                        ></mdl-datepicker>
                    </div>

                    <div class="form-group">
                        Время прихода
                        <time-selector v-model="time.start_time" :required="true"></time-selector>
                    </div>

                    <div class="form-group">
                        Время ухода
                        <time-selector v-model="time.end_time" :required="true"></time-selector>
                    </div>

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
            const blankWorker = {
                id: 0,
                firstName: null,
                family: null,
            };

            let blankTime = this.createGoodTime(new Date());

            const time = {
                worker_id: this.$route.params.workerId,
                date: new Date(),
                start_time: blankTime,
                end_time: blankTime
            };

            return {
                error: null,
                isOpenModalResult: false,
                resultSave: null,
                formErrors: [],
                linkList: '/times/all',
                workerId: this.$route.params.workerId,
                worker: blankWorker,
                time,
                lang: {
                    formatLocale: {
                        firstDayOfWeek: 1,
                    },
                    monthBeforeYear: false
                }
            }
        },

        methods: {
            save() {
                this.resultSave = null;

                const options = {
                    'entryData': this.time
                };

                axios.post(API_URL + '/times/', options)
                    .then((response) => {
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
                axios.get(API_URL + '/worker/' + this.workerId)
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

                if (this.time.end_time <= this.time.start_time) {
                    this.formErrors.push('Время ухода раньше, чем время прихода!');
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
            createGoodTime(date) {
                let minutes = date.getMinutes();
                if (minutes < 10) {
                    date.setMinutes(10);
                } else if ((minutes % 10) !== 0) {
                    minutes = Math.trunc(minutes / 10) * 10;

                    date.setMinutes(minutes);
                }

                return date;
            }
        },

        created() {
            document.title = 'Внести отметку о посещении';
            this.loadWorker();
        }
    }
</script>

<style type="text/css">
    .vtimeselector__input {
        cursor: pointer;
        padding: 5px;
        border: none;
        border-bottom: 1px solid #e0e0e0;
    }
    .datepicker-input-container {
        cursor: pointer;
        width: 100%;
    }
</style>

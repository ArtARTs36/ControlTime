<template>
    <mdb-card v-if="workerId > 0">
        <mdb-card-body>
            <mdb-card-title>Внести отметку о посещении сотрудника:
                {{ worker.name }} {{ worker.family }}
            </mdb-card-title>

            <form @submit="checkForm">
                <mdb-card-text>
                    <div class="form-group">
                        Дата прихода
                        <mdl-datepicker
                            v-bind:minDate="minDate"
                            v-bind:disableYearSelection
                                ="disableYearSelection"
                            v-bind:maxDate="currentDate"
                            orientation="landscape"
                            v-model="time.start_date"
                            :default="time.start_date"
                        ></mdl-datepicker>
                    </div>

                    <div class="form-group">
                        Дата ухода
                        <mdl-datepicker
                            v-bind:minDate="minDate"
                            v-bind:disableYearSelection
                                ="disableYearSelection"
                            v-bind:maxDate="currentDate"
                            orientation="landscape"
                            v-model="time.end_date"
                            :default="time.end_date"
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

            let blankEndTime = new Date();

            if (blankEndTime.getHours() + 4 < 24) {
                blankEndTime.setHours(blankEndTime.getHours() + 4);
            }

            const time = {
                worker_id: this.$route.params.workerId,
                start_date: new Date(),
                end_date: new Date(),
                start_time: blankTime,
                end_time: blankEndTime
            };

            let currentDate = new Date();

            let minDate = new Date();
            minDate.setDate(currentDate.getDate() - 32);

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
                },
                disableYearSelection: false,
                hiredDate: null,
                currentDate,
                minDate
            }
        },

        methods: {
            save() {
                this.resultSave = null;

                const options = {
                    'entryData': {
                        'worker_id': this.worker.id,
                        'start_date': this.time.start_date.toLocaleDateString(),
                        'start_time': this.time.start_time.toLocaleTimeString(),
                        'end_date': this.time.end_date.toLocaleDateString(),
                        'end_time': this.time.end_time.toLocaleTimeString(),
                    }
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
                axios.get(API_URL + '/workers/' + this.workerId)
                    .then(response => {
                        this.worker = response.data;

                        this.hiredDate = new Date(this.worker.hired_date);
                        if (this.hiredDate > this.minDate) {
                            this.minDate = this.hiredDate;
                        }

                        if (this.hiredDate.getFullYear() === this.currentDate.getFullYear()) {
                            this.disableYearSelection = true;
                        }
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

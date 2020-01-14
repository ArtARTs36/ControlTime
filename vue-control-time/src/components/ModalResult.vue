<template>
    <mdb-modal size="md" :show="isOpenModalResult" @close="closeModal()">
        <mdb-modal-header>
            <mdb-modal-title>{{ title }}</mdb-modal-title>
        </mdb-modal-header>
        <mdb-modal-body>
            <p v-if="formErrors && formErrors.length">
                <strong>Пожалуйста исправьте указанные ошибки:</strong>
                <mdb-alert color="danger">
                    <ul>
                        <li v-for="error in formErrors">{{ error }}</li>
                    </ul>
                </mdb-alert>
            </p>
            {{ result }}
        </mdb-modal-body>
        <mdb-modal-footer>
            <mdb-btn color="secondary" size="sm" @click.native="closeModal">Закрыть</mdb-btn>
            <router-link v-bind:to="backLink" v-if="backLink">
                <mdb-btn color="primary" size="sm">Вернуться к списку</mdb-btn>
            </router-link>
        </mdb-modal-footer>
    </mdb-modal>
</template>

<script>
    import { mdbBtn, mdbInput,
        mdbModal, mdbModalHeader, mdbModalTitle, mdbModalBody, mdbModalFooter, mdbAlert} from 'mdbvue';
    export default {
        components: {
            mdbBtn,
            mdbInput,
            mdbModal,
            mdbModalHeader,
            mdbModalTitle,
            mdbModalBody,
            mdbModalFooter,
            mdbAlert
        },

        props: [
            'result', 'isOpenModalResult', 'formErrors', 'backLink', 'title'
        ],

        methods: {
            closeModal() {
                this.$emit('closeModal');
            }
        },
        mounted() {
            if (this.title === undefined) {
                this.title = 'Результат сохранения информации';
            }
        }
    }
</script>

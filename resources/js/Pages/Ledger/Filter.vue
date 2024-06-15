<script setup>
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import SuccessButton from "@/Components/SuccessButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from '@/Components/InputError.vue';
import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import { onMounted } from "vue";
import moment from 'moment';

defineProps({
    companies: Array
});

const modal = ref(false);
const edit = ref(false);
const companies = usePage().props.companies;
const ledger_company_id = usePage().props.ledger_company_id;

var saved_filters = "";

const form = useForm({
    company: ledger_company_id || "",
    from_date: "",
    to_date: "",
});

const create = () => {
    modal.value = true;
    edit.value = false;

    saved_filters = localStorage.getItem('filters');
    if (saved_filters) {
        saved_filters = JSON.parse(saved_filters);
        form.company = saved_filters.company
        // form.date = saved_filters.date
    }
};

const submit = () => {
    var filters = {
        company: form.company,
        from_date: form.from_date,
        to_date: form.to_date,
    };

    form.post(route("ledger.index"), {
        preserveScroll: true,
        onSuccess: (response) => {
            closeModal();
            localStorage.setItem('filters', JSON.stringify(filters));
        },
        onError: (errors) => {
            console.log(errors)
        },
        onFinish: () => { },
    });
};

const error = () => {
    // 
};

const closeModal = () => {
    modal.value = false;
    form.reset();
};

const format_date = (date) => {
    let parsedDate = moment(date);
    // let newDate = parsedDate.add(5, 'hours');
    let formattedDate = parsedDate.format('YYYY-MM-DD');
    return formattedDate;
}

watch(
    () => {
        if (form.from_date) {
            form.from_date = format_date(form.from_date)
        }
        if (form.to_date) {
            form.to_date = format_date(form.to_date)
        }
    }
);
</script>

<template>
    <PrimaryButton @click="create" type="button">Search</PrimaryButton>

    <Modal :show="modal" @close="closeModal">
        <form @submit.prevent="edit ? update() : submit()">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">Search Ledger</h2>

                <p class="mt-1 text-sm text-gray-600">
                    Once your account is added, you can simply search by account
                    number, and the address will be fetched accordingly in invoice form.
                </p>

                <div class="mt-6">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <InputLabel for="" value="Company" class="mb-1" />
                            <select v-model="form.company" class="form-control">
                                <template v-for="company in companies">
                                    <option :value="company.id">{{ company.name }}</option>
                                </template>
                            </select>
                            <InputError :message="form.errors.company" />
                        </div>

                        <div class="col-md-3">
                            <InputLabel for="" value="From Date" class="mb-1" />
                            <VueDatePicker v-model="form.from_date" :teleport="true" :enable-time-picker="false">
                            </VueDatePicker>
                            <InputError :message="form.errors.from_date" />
                        </div>
                        <div class="col-md-3">
                            <InputLabel for="" value="To Date" class="mb-1" />
                            <VueDatePicker v-model="form.to_date" :teleport="true" :enable-time-picker="false">
                            </VueDatePicker>
                            <InputError :message="form.errors.to_date" />
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                    <SuccessButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Search
                    </SuccessButton>
                </div>
            </div>
        </form>
    </Modal>
</template>

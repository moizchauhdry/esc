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

defineProps({
    companies: Array
});

const modal = ref(false);
const edit = ref(false);

const form = useForm({
    company_id: "",
    date: ""
});

const create = () => {
    modal.value = true;
    edit.value = false;
};

const submit = () => {
    form.post(route("invoice.ledger"), {
        preserveScroll: true,
        onSuccess: (response) => {
            console.log(response);
            closeModal();
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
</script>

<template>
    <PrimaryButton @click="create" type="button">Search Ledger</PrimaryButton>

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
                            <select v-model="form.company_id" class="form-control">
                                <template v-for="company in companies">
                                    <option :value="company.id">{{ company.name }}</option>
                                </template>
                            </select>
                            <InputError :message="form.errors.company_id" />
                        </div>

                        <div class="col-md-6">
                            <InputLabel for="" value="Date" class="mb-1" />
                            <VueDatePicker v-model="form.date" :teleport="true" range></VueDatePicker>
                            <InputError :message="form.errors.date" />
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                    <SuccessButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Search
                    </SuccessButton>

                    <a :href="route('invoice.ledger')" title="" class="ms-1" target="_blank"><i
                            class='bx bxs-printer'></i>Print Ledger</a>
                </div>
            </div>
        </form>
    </Modal>
</template>
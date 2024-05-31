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

defineProps({
    companies: Array
});

const modal = ref(false);
const edit = ref(false);
const companies = usePage().props.companies;

const form = useForm({
    company_id: "",
    balance: "",
    credit: "",
});

const create = () => {
    modal.value = true;
    edit.value = false;
};

const submit = () => {
    form.post(route("ledger.payment"), {
        preserveScroll: true,
        onSuccess: (response) => {
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
    <PrimaryButton @click="create" type="button">Payment</PrimaryButton>

    <Modal :show="modal" @close="closeModal">
        <form @submit.prevent="edit ? update() : submit()">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">Legder Payment</h2>
                <hr>

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
                        <div class="col-md-3">
                            <InputLabel for="" value="Total Balance" class="mb-1" />
                            <input type="text" class="form-control" v-model="form.balance">
                            <InputError :message="form.errors.balance" />
                        </div>
                        <div class="col-md-3">
                            <InputLabel for="" value="Credit Amount" class="mb-1" />
                            <input type="text" class="form-control" v-model="form.credit">
                            <InputError :message="form.errors.credit" />
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                    <SuccessButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Save
                    </SuccessButton>
                </div>
            </div>
        </form>
    </Modal>
</template>

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
    companies: Array,
    balance: Array,
});

const modal = ref(false);
const edit_mode = ref(false);
const companies = usePage().props.companies;

const form = useForm({
    id: "",
    company_id: "",
    credit: "",
    ledger_at: "",
    comments: "",
});

const edit = (ledger) => {
    modal.value = true;
    edit_mode.value = true;
    form.id = ledger.id
    form.company_id = ledger.company_id
    form.credit = ledger.credit
    // form.ledger_at = new Date(ledger.ledger_at)
    form.ledger_at = ledger.ledger_at
    form.comments = ledger.comments
};

const update = () => {
    form.post(route("ledger.update"), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => error(),
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

defineExpose({ edit: (ledger) => edit(ledger) });

</script>

<template>
    <button type="button" @click="create" title="Edit" clas="btn btn-primary"></button>

    <Modal :show="modal" @close="closeModal">
        <form @submit.prevent="update()">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">Edit Legder Payment</h2>
                <hr>

                <div class="mt-6">
                    <div class="row g-2">
                        <div class="col-md-12">
                            <InputLabel for="" value="Company" class="mb-1" />
                            <select v-model="form.company_id" class="form-control">
                                <template v-for="company in companies">
                                    <option :value="company.id">{{ company.name }}</option>
                                </template>
                            </select>
                            <InputError :message="form.errors.company_id" />
                        </div>
                        <div class="col-md-6">
                            <InputLabel for="" value="Payment Date" class="mb-1" />
                            <!-- <VueDatePicker v-model="form.ledger_at" :teleport="true" :enable-time-picker="false">
                            </VueDatePicker> -->
                            <input type="date" class="form-control" v-model="form.ledger_at">

                            <InputError :message="form.errors.ledger_at" />
                        </div>
                        <div class="col-md-6">
                            <InputLabel for="" value="Credit Amount" class="mb-1" />
                            <input type="text" class="form-control" v-model="form.credit">
                            <InputError :message="form.errors.credit" />
                        </div>
                        <div class="col-md-12">
                            <InputLabel for="" value="Comments" class="mb-1" />
                            <textarea class="form-control" v-model="form.comments" id="comments" rows="5"></textarea>
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

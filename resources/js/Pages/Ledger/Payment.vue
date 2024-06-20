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
    companies: Array,
    balance: Array,
});

const modal = ref(false);
const edit = ref(false);
const companies = usePage().props.companies;
const ledger_company_id = usePage().props.ledger_company_id;

const form = useForm({
    company_id: ledger_company_id || "",
    balance_total: 0,
    credit: "",
    ledger_at: "",
    comments: "",
});

const create = () => {
    modal.value = true;
    edit.value = false;

    fetchLedgerBalance();
};

const fetchLedgerBalance = () => {
    axios.post(route('ledger.balance'), form)
        .then(({ data }) => {
            form.balance_total = data.balance_total
        })
        .catch(error => {
            // 
        });
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

onMounted(() => {
    // 
});

</script>

<template>
    <PrimaryButton @click="create" type="button" class="mx-1">Payment</PrimaryButton>

    <Modal :show="modal" @close="closeModal">
        <form @submit.prevent="edit ? update() : submit()">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">Legder Payment</h2>
                <hr>

                <div class="mt-6">
                    <div class="row g-2">
                        <div class="col-md-7">
                            <InputLabel for="" value="Company" class="mb-1" />
                            <select v-model="form.company_id" class="form-control">
                                <template v-for="company in companies">
                                    <option :value="company.id">{{ company.name }}</option>
                                </template>
                            </select>
                            <InputError :message="form.errors.company_id" />
                        </div>
                        <div class="col-md-5">
                            <InputLabel for="" value="Payment Date" class="mb-1" />
                            <VueDatePicker v-model="form.ledger_at" :teleport="true" :enable-time-picker="false">
                            </VueDatePicker>
                            <InputError :message="form.errors.ledger_at" />
                        </div>
                        <div class="col-md-3">
                            <InputLabel for="" value="Balance" class="mb-1" />
                            <input type="text" class="form-control" v-model="form.balance_total" readonly>
                            <InputError :message="form.errors.balance_total" />
                        </div>
                        <div class="col-md-3">
                            <InputLabel for="" value="Credit Amount" class="mb-1" />
                            <input type="text" class="form-control" v-model="form.credit">
                            <InputError :message="form.errors.credit" />
                        </div>
                        <div class="col-md-12">
                            <InputLabel for="" value="Comments" class="mb-1" />
                            <textarea class="form-control" v-model="form.comments" id="comments" rows="3"></textarea>
                            <!-- <InputError :message="form.errors.Comments" /> -->
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

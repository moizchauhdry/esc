<script setup>
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import SuccessButton from "@/Components/SuccessButton.vue";
import InputError from '@/Components/InputError.vue';

const modal = ref(false);

const form = useForm({
    invoice_id: "",
    due_carrier: "",
    net_rate: "",
});

const edit = (invoice) => {
    console.log(invoice)
    if (invoice) {
        modal.value = true;
        form.invoice_id = invoice.id
        form.due_carrier = invoice.due_carrier
        form.net_rate = invoice.net_rate
    }
};

const update = () => {
    form.post(route("report.sale.update"), {
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

defineExpose({ edit: (invoice) => edit(invoice) });
</script>

<template>

    <Modal :show="modal" @close="closeModal">
        <form @submit.prevent="update()">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">Edit</h2>
                <hr>
                <div class="mt-6">

                    <div class="row g-3 mt-2">
                        <div class="col-md-6">
                            <label for="" class="form-label">Due Carrier</label>
                            <input type="text" v-model="form.due_carrier" class="form-control">
                            <InputError :message="form.errors.due_carrier" />
                        </div>
                        <div class="col-md-6">
                            <label for="" class="form-label">Net Rate</label>
                            <input type="text" v-model="form.net_rate" class="form-control">
                            <InputError :message="form.errors.net_rate" />
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>
                    <SuccessButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Save & Update
                    </SuccessButton>
                </div>
            </div>
        </form>
    </Modal>
</template>
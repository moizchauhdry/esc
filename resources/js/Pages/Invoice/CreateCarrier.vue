<script setup>
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import SuccessButton from "@/Components/SuccessButton.vue";
import InputError from '@/Components/InputError.vue';

const modal = ref(false);
const edit_mode = ref(false);

const form = useForm({
    carrier_id: "",
    carrier_name: "",
    carrier_code: "",
});

const create = () => {
    modal.value = true;
    edit_mode.value = false;
};

const submit = () => {
    form.post(route("carrier.store"), {
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


const editCarrier = (carrier) => {
    if (carrier) {
        modal.value = true;
        edit_mode.value = true;
        form.carrier_id = carrier.id
        form.carrier_name = carrier.carrier_name
        form.carrier_code = carrier.carrier_code
    }
};

const update = () => {
    form.post(route("carrier.update"), {
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

defineExpose({ editCarrier: (carrier) => editCarrier(carrier) });
</script>

<template>
    <PrimaryButton @click="create" type="button">Add</PrimaryButton>

    <Modal :show="modal" @close="closeModal">
        <form @submit.prevent="edit_mode ? update() : submit()">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">Carrier {{ edit_mode ? 'Edit' : 'Create' }}</h2>
                <hr>
                <div class="mt-6">

                    <div class="row g-3 mt-2">
                        <div class="col-md-6">
                            <label for="" class="form-label">Carrier Name</label>
                            <input type="text" v-model="form.carrier_name" class="form-control">
                            <InputError :message="form.errors.carrier_name" />
                        </div>
                        <div class="col-md-6">
                            <label for="" class="form-label">Carrier Code</label>
                            <input type="text" v-model="form.carrier_code" class="form-control">
                            <InputError :message="form.errors.carrier_code" />
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>
                    <SuccessButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        {{ edit_mode ? 'Save & Update' : 'Save & Submit' }}
                    </SuccessButton>
                </div>
            </div>
        </form>
    </Modal>
</template>
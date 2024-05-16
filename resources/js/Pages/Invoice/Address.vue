<script setup>
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import SuccessButton from "@/Components/SuccessButton.vue";
import InputError from '@/Components/InputError.vue';

const address_modal = ref(false);
const edit_mode = ref(false);

const form = useForm({
    type: "",
    name: "",
    address_1: "",
    address_2: "",
    city: "",
    state: "",
    country: "",
    zipcode: "",
    phone: "",
    email: ""
});

const create = () => {
    address_modal.value = true;
    edit_mode.value = false;
};

const submit = () => {
    form.post(route("address.create"), {
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


const edit = () => {
    address_modal.value = true;
    edit_mode.value = true;
};

const update = () => {
    form.post(route("invoice.update"), {
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
    address_modal.value = false;
    form.reset();
};
</script>

<template>
    <div class="col">
        <PrimaryButton @click="create">Add</PrimaryButton>

        <Modal :show="address_modal" @close="closeModal">
            <form @submit.prevent="edit_mode ? update() : submit()">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900">Shipper & Consignee Account</h2>

                    <p class="mt-1 text-sm text-gray-600">
                        Once your account is added, you can simply search by account
                        number, and the address will be fetched accordingly in invoice form.
                    </p>

                    <div class="mt-6">
                        
                        <div class="row g-2">
                            <div class="col-md-4">
                                <label for="">Type</label>
                                <select v-model="form.type" class="form-control">
                                    <option value="shipper">Shipper</option>
                                    <option value="consignee">Consignee</option>
                                </select>
                                <InputError :message="form.errors.type" />
                            </div>
                            <div class="col-md-8">
                                <label for="">Account Name</label>
                                <input type="text" v-model="form.name" class="form-control">
                                <InputError :message="form.errors.name" />
                            </div>
                            <div class="col-md-6">
                                <label for="">Address Line 1</label>
                                <input type="text" v-model="form.address_1" class="form-control">
                                <InputError :message="form.errors.address_1" />
                            </div>
                            <div class="col-md-6">
                                <label for="">Address Line 2</label>
                                <input type="text" v-model="form.address_2" class="form-control">
                                <InputError :message="form.errors.address_2" />
                            </div>
                            <div class="col-md-3">
                                <label for="">City</label>
                                <input type="text" v-model="form.city" class="form-control">
                                <InputError :message="form.errors.city" />
                            </div>
                            <div class="col-md-3">
                                <label for="">State</label>
                                <input type="text" v-model="form.state" class="form-control">
                                <InputError :message="form.errors.state" />
                            </div>
                            <div class="col-md-3">
                                <label for="">Country</label>
                                <input type="text" v-model="form.country" class="form-control">
                                <InputError :message="form.errors.country" />
                            </div>
                            <div class="col-md-3">
                                <label for="">Zipcode</label>
                                <input type="text" v-model="form.zipcode" class="form-control">
                                <InputError :message="form.errors.zipcode" />
                            </div>
                            <div class="col-md-6">
                                <label for="">Phone</label>
                                <input type="text" v-model="form.phone" class="form-control">
                                <InputError :message="form.errors.phone" />
                            </div>
                            <div class="col-md-6">
                                <label for="">Email</label>
                                <input type="text" v-model="form.email" class="form-control">
                                <InputError :message="form.errors.email" />
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                        <SuccessButton class="ml-3" :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing">
                            Save
                        </SuccessButton>
                    </div>
                </div>
            </form>
        </Modal>
    </div>
</template>
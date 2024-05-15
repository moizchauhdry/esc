<script setup>
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import { ref, watch } from "vue";

const address_modal = ref(false);
const edit_mode = ref(false);

const address_form = useForm({
    type: 1,
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
    address_form.post(route("address.create"), {
        preserveScroll: true,
        onSuccess: (response) => {
            console.log(response)
            closeModal()
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
    address_form.post(route("invoice.update"), {
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
    address_form.reset();
};
</script>

<template>
    <div class="col">
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleLargeModal"
            @click="create"><i class="bx bx-plus"></i></button>
        <div class="modal fade show" id="exampleLargeModal" tabindex="-1" aria-hidden="true" style="display: block;"
            v-if="address_modal">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <form @submit.prevent="edit_mode ? update() : submit()">
                        <div class="modal-header">
                            <h5 class="modal-title">Shipper Add</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                @click="closeModal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label for="">Type</label>
                                    <select v-model="address_form.type" class="form-control">
                                        <option value="shipper">Shipper</option>
                                        <option value="consignee">Consignee</option>
                                    </select>
                                    <InputError :message="address_form.errors.type" />
                                </div>
                                <div class="col-md-12">
                                    <label for="">Address Line 1</label>
                                    <input type="text" v-model="address_form.address_1" class="form-control">
                                    <InputError :message="address_form.errors.address_1" />
                                </div>
                                <div class="col-md-12">
                                    <label for="">Address Line 2</label>
                                    <input type="text" v-model="address_form.address_2" class="form-control">
                                    <InputError :message="address_form.errors.address_2" />
                                </div>
                                <div class="col-md-3">
                                    <label for="">City</label>
                                    <input type="text" v-model="address_form.city" class="form-control">
                                    <InputError :message="address_form.errors.city" />
                                </div>
                                <div class="col-md-3">
                                    <label for="">State</label>
                                    <input type="text" v-model="address_form.state" class="form-control">
                                    <InputError :message="address_form.errors.state" />
                                </div>
                                <div class="col-md-3">
                                    <label for="">Country</label>
                                    <input type="text" v-model="address_form.country" class="form-control">
                                    <InputError :message="address_form.errors.country" />
                                </div>
                                <div class="col-md-3">
                                    <label for="">Zipcode</label>
                                    <input type="text" v-model="address_form.zipcode" class="form-control">
                                    <InputError :message="address_form.errors.zipcode" />
                                </div>
                                <div class="col-md-6">
                                    <label for="">Phone</label>
                                    <input type="text" v-model="address_form.phone" class="form-control">
                                    <InputError :message="address_form.errors.phone" />
                                </div>
                                <div class="col-md-6">
                                    <label for="">Email</label>
                                    <input type="text" v-model="address_form.email" class="form-control">
                                    <InputError :message="address_form.errors.email" />
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"
                                @click="closeModal">Close</button>

                            <button type="submit" class="btn btn-primary btn-sm">
                                {{ edit_mode ? 'Save & Update' : 'Save & Submit' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import SuccessButton from "@/Components/SuccessButton.vue";
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    roles: Object,
    selected_role: Number
});

const modal = ref(false);
const edit_mode = ref(false);

const form = useForm({
    user_id: "",
    name: "",
    phone: "",
    email: "",
    password: "",
    password_confirmation: "",
    role: "",
    address_1: "",
    address_2: "",
    city: "",
    state: "",
    country: "",
    zipcode: "",
});

const create = () => {
    modal.value = true;
    edit_mode.value = false;
    if (props.selected_role) {
        form.role = props.selected_role;
    }
};

const submit = () => {
    form.post(route("user.store"), {
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


const edit = (user) => {
    console.log(user);
    modal.value = true;
    edit_mode.value = true;
    form.user_id = user.id
    form.role = user.role_id
    form.name = user.name
    form.phone = user.phone
    form.email = user.email
    form.address_1 = user.address_1
    form.address_2 = user.address_2
    form.city = user.city
    form.state = user.state
    form.country = user.country
    form.zipcode = user.zipcode
};

const update = () => {
    form.post(route("user.update"), {
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

defineExpose({ edit: (user) => edit(user) });
</script>

<template>
    <PrimaryButton @click="create" type="button">Add</PrimaryButton>

    <Modal :show="modal" @close="closeModal">
        <form @submit.prevent="edit_mode ? update() : submit()">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">User {{ edit_mode ? 'Edit' : 'Create' }}</h2>
                <hr>
                <div class="mt-6">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="input21" class="form-label">Role</label>
                            <select id="input21" class="form-select" v-model="form.role" :disabled="edit_mode">
                                <option value="">Choose...</option>
                                <template v-for="role in roles" :key="role.id">
                                    <option :value="role.id">{{ role.name }}</option>
                                </template>
                            </select>
                            <InputError :message="form.errors.role" />
                        </div>
                        <div class="col-md-8">
                            <label for="input13" class="form-label">Name</label>
                            <div class="position-relative input-icon">
                                <input type="text" class="form-control" id="input13" placeholder="Name"
                                    v-model="form.name">
                                <span class="position-absolute top-50 translate-middle-y"><i
                                        class='bx bx-user'></i></span>
                            </div>
                            <InputError :message="form.errors.name" />
                        </div>
                        <div class="col-md-6">
                            <label for="input15" class="form-label">Phone</label>
                            <div class="position-relative input-icon">
                                <input type="text" class="form-control" id="input15" placeholder="Phone"
                                    v-model="form.phone">
                                <span class="position-absolute top-50 translate-middle-y"><i
                                        class='bx bx-phone'></i></span>
                            </div>
                            <InputError :message="form.errors.phone" />
                        </div>

                        <div class="col-md-6" v-if="!([3, 4].includes(form.role))">
                            <label for="input16" class="form-label">Email</label>
                            <div class="position-relative input-icon">
                                <input type="text" class="form-control" id="input16" placeholder="Email"
                                    v-model="form.email">
                                <span class="position-absolute top-50 translate-middle-y"><i
                                        class='bx bx-envelope'></i></span>
                            </div>
                            <InputError :message="form.errors.email" />
                        </div>

                        <template v-if="!edit_mode && !([3, 4].includes(form.role))">
                            <div class="col-md-6">
                                <label for="input17" class="form-label">Password</label>
                                <div class="position-relative input-icon">
                                    <input type="password" class="form-control" id="input17" placeholder="Password"
                                        v-model="form.password">
                                    <span class="position-absolute top-50 translate-middle-y"><i
                                            class='bx bx-lock-alt'></i></span>
                                </div>
                                <InputError :message="form.errors.password" />
                            </div>
                            <div class="col-md-6">
                                <label for="input17" class="form-label">Confirm
                                    Password</label>
                                <div class="position-relative input-icon">
                                    <input type="password" class="form-control" id="input17" placeholder="Password"
                                        v-model="form.password_confirmation">
                                    <span class="position-absolute top-50 translate-middle-y"><i
                                            class='bx bx-lock-alt'></i></span>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="row g-3 mt-2">
                        <div class="col-md-6">
                            <label for="" class="form-label">Address Line 1</label>
                            <input type="text" v-model="form.address_1" class="form-control">
                            <InputError :message="form.errors.address_1" />
                        </div>
                        <div class="col-md-6">
                            <label for="" class="form-label">Address Line 2</label>
                            <input type="text" v-model="form.address_2" class="form-control">
                            <InputError :message="form.errors.address_2" />
                        </div>
                        <div class="col-md-3">
                            <label for="" class="form-label">City</label>
                            <input type="text" v-model="form.city" class="form-control">
                            <InputError :message="form.errors.city" />
                        </div>
                        <div class="col-md-3">
                            <label for="" class="form-label">State</label>
                            <input type="text" v-model="form.state" class="form-control">
                            <InputError :message="form.errors.state" />
                        </div>
                        <div class="col-md-3">
                            <label for="" class="form-label">Country</label>
                            <input type="text" v-model="form.country" class="form-control">
                            <InputError :message="form.errors.country" />
                        </div>
                        <div class="col-md-3">
                            <label for="" class="form-label">Zipcode</label>
                            <input type="text" v-model="form.zipcode" class="form-control">
                            <InputError :message="form.errors.zipcode" />
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
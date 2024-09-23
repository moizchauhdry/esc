<script setup>
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import SuccessButton from "@/Components/SuccessButton.vue";
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    // 
});

const modal = ref(false);

const password_form = useForm({
    user_id: "",
    password: "",
    password_confirmation: ""
});

const create = () => {
    modal.value = true;
};

const submit = () => {
    password_form.post(route("user.reset-password"), {
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
    password_form.reset();
};


const resetpasswordfunc = (user) => {
    if (user) {
        modal.value = true;
        password_form.user_id = user.id;
        password_form.password = "";
        password_form.password_confirmation = ""
    }
};

defineExpose({ resetpasswordfunc: (user) => resetpasswordfunc(user) });
</script>

<template>
    <Modal :show="modal" @close="closeModal">
        <form @submit.prevent="submit()">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">Reset Password</h2>
                <hr>
                <div class="mt-6">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="input17" class="form-label">Password</label>
                            <div class="position-relative input-icon">
                                <input type="password" class="form-control" id="input17" placeholder="Password"
                                    v-model="password_form.password">
                                <span class="position-absolute top-50 translate-middle-y"><i
                                        class='bx bx-lock-alt'></i></span>
                            </div>
                            <InputError :message="password_form.errors.password" />
                        </div>
                        <div class="col-md-6">
                            <label for="input17" class="form-label">Confirm
                                Password</label>
                            <div class="position-relative input-icon">
                                <input type="password" class="form-control" id="input17" placeholder="Password"
                                    v-model="password_form.password_confirmation">
                                <span class="position-absolute top-50 translate-middle-y"><i
                                        class='bx bx-lock-alt'></i></span>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                    <SuccessButton class="ml-3" :class="{ 'opacity-25': password_form.processing }"
                        :disabled="password_form.processing">
                        Reset Password
                    </SuccessButton>
                </div>
            </div>
        </form>
    </Modal>
</template>
<script setup>
import DangerButton from "@/Components/DangerButton.vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { nextTick, ref } from "vue";
import { Head, Link, usePage, useForm } from "@inertiajs/vue3";

const props = defineProps({
    upload_id: Object,
});

const upload_id = props.upload_id;
const confirmingDeletion = ref(false);

const confirmUserDeletion = () => {
    confirmingDeletion.value = true;
};

const form = useForm({
    upload_id: upload_id
});

const deleteRecord = () => {
    form.delete(route("invoice.upload.destroy"), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => { },
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingDeletion.value = false;
    form.reset();
};
</script>

<template>
    <section class="space-y-6">

        <DangerButton @click="confirmUserDeletion">Delete</DangerButton>

        <Modal :show="confirmingDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Are you sure you want to delete?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Once your account is deleted, all of its resources and data
                    will be permanently deleted.
                </p>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal">
                        Cancel
                    </SecondaryButton>

                    <DangerButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                        @click="deleteRecord">
                        Delete
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>

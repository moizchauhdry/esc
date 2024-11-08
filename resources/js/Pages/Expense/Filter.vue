<script setup>
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import SuccessButton from "@/Components/SuccessButton.vue";
import InputLabel from "@/Components/InputLabel.vue";

defineProps({
    filter: Object,
});

const modal = ref(false);
const edit = ref(false);
const filter = usePage().props.filter;

var saved_filters = "";

const form = useForm({
    from_date: filter.from_date,
    to_date: filter.to_date,
});

const create = () => {
    modal.value = true;
    edit.value = false;
    saved_filters = localStorage.getItem('filters');
    if (saved_filters) {
        saved_filters = JSON.parse(saved_filters);
        form.from_date = saved_filters.from_date
        form.to_date = saved_filters.to_date
    }
};

const submit = () => {
    var filters = {
        from_date: form.from_date,
        to_date: form.to_date,
    };

    const queryParams = new URLSearchParams(filters).toString();
    const urlWithFilters = `${route("expense.index")}?${queryParams}`;

    form.post(urlWithFilters, {
        preserveScroll: true,
        onSuccess: (response) => {
            closeModal();
            localStorage.setItem('filters', JSON.stringify(filters));
        },
        onError: (errors) => {
            console.log(errors);
        },
        onFinish: () => { },
    });
};

const closeModal = () => {
    modal.value = false;
    form.reset();
};
</script>

<template>
    <PrimaryButton @click="create" type="button" class="mx-1">Search</PrimaryButton>

    <Modal :show="modal" @close="closeModal">
        <form @submit.prevent="edit ? update() : submit()">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">Search Filter</h2> <hr>

                <div class="mt-6">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <InputLabel for="" value="Month" class="mb-1" />
                            <input type="date" v-model="form.from_date" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <InputLabel for="" value="Month" class="mb-1" />
                            <input type="date" v-model="form.to_date" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>
                    <SuccessButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Search</SuccessButton>
                </div>
            </div>
        </form>
    </Modal>
</template>

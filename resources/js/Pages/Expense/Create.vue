<script setup>
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import SuccessButton from "@/Components/SuccessButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from '@/Components/InputError.vue';
import { onMounted } from "vue";

defineProps({
    filter: Object,
});

const modal = ref(false);
const edit_mode = ref(false);

const filter = usePage().props.filter;

const form = useForm({
    items: [
        {
            description: "",
            amount: "",
        }
    ],
    total: "",
    expense_at: "",
    expense_id: "",
});

const create = () => {
    modal.value = true;
    edit.value = false;
    form.total = 0;
};

const submit = () => {
    form.post(route("expense.store"), {
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

const edit = (expense) => {
    if (expense) {
        modal.value = true;
        edit_mode.value = true;
        form.expense_id = expense.id

        axios.get(`/expenses/fetch/expense-items/${expense.id}`)
            .then(({ data }) => {
                form.items = data.particulars
            });
    }
};

const update = () => {
    form.post(route("expense.update"), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => error(),
        onFinish: () => { },
    });
};

const closeModal = () => {
    modal.value = false;
    form.reset();
};

const addItem = () => {
    form.items.push({
        year: filter.year,
        month: filter.month,
        description: "",
        amount: "",
    });
};

const removeItem = (index) => {
    form.items.splice(index, 1);
    getGrandTotal();
};

const getGrandTotal = () => {
    form.total = 0;
    form.items.forEach((item) => {
        form.total += parseFloat(item.amount);
    });
};

const format_number = (number) => {
    return new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(number);
};

defineExpose({ edit: (template) => edit(template) });

onMounted(() => {
    if (!edit_mode) {
        form.items = [
            {
                year: filter.year,
                month: filter.month,
                description: "",
                amount: "",
            },
        ];
    }

    if (edit_mode) {
        getGrandTotal();
    }
});

</script>

<template>
    <SuccessButton @click="create" type="button" class="mx-1"><i class='bx bx-plus'></i> Add Expense</SuccessButton>

    <Modal :show="modal" @close="closeModal">
        <form @submit.prevent="edit_mode ? update() : submit()">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    <span>Add Expense</span>
                    <SuccessButton type="button" class="float-right" @click="addItem()"><i
                            class='bx bx-plus text-lg'></i>Add
                        Item</SuccessButton>
                </h2>
                <hr>
                <div class="mt-6">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <InputLabel for="" value="Month" class="mb-1" />
                            <input type="date" v-model="form.expense_at" class="form-control">
                            <InputError :message="form.errors.expense_at" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table v-if="form.items.length > 0" class="mt-3">
                                <thead>
                                    <tr>
                                        <td class="text-left">DESCRIPTION</td>
                                        <td class="text-left">AMOUNT</td>
                                        <td class="text-left"></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-for="(item, index) in form.items" :key="item.id">
                                        <tr>
                                            <td class="text-left" style="width:50%">
                                                <input type="text" class="form-control" v-model="item.description">
                                            </td>
                                            <td class="total" style="width:15%">
                                                <input type="number" class="form-control" v-model="item.amount"
                                                    @keyup="getGrandTotal">
                                            </td>
                                            <td class="no" style="width:5%">
                                                <button type="button" @click="removeItem(index)"
                                                    class="ms-1 text-danger text-lg"><i
                                                        class='bx bxs-trash'></i></button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-right">TOTAL</th>
                                        <th class="text-right">{{ format_number(form.total) }}</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
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

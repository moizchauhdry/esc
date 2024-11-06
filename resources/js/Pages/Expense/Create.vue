<script setup>
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import SuccessButton from "@/Components/SuccessButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
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
            year: filter.year,
            month: filter.month,
            description: "",
            amount: "",
        }
    ],
    total:""
});

var months = [
    { id: 1, name: "January" },
    { id: 2, name: "February" },
    { id: 3, name: "March" },
    { id: 4, name: "April" },
    { id: 5, name: "May" },
    { id: 6, name: "June" },
    { id: 7, name: "July" },
    { id: 8, name: "August" },
    { id: 9, name: "September" },
    { id: 10, name: "October" },
    { id: 11, name: "November" },
    { id: 12, name: "December" },
];

var years = [
    { id: 1, value: "2023" },
    { id: 2, value: "2024" },
    { id: 3, value: "2025" },
    { id: 4, value: "2026" },
    { id: 5, value: "2027" },
    { id: 6, value: "2028" },
    { id: 7, value: "2029" },
    { id: 8, value: "2030" },
];

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
    <SuccessButton @click="create" type="button" class="mx-1">Add Expense</SuccessButton>

    <Modal :show="modal" @close="closeModal">
        <form @submit.prevent="edit_mode ? update() : submit()">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    <span>Add Expense</span> 
                    <SuccessButton type="button" class="float-right" @click="addItem()"><i class='bx bx-plus'></i>Add Item</SuccessButton>
                </h2>
                <hr>
                <div class="mt-6">
                    <div class="row">
                        <table v-if="form.items.length > 0">
                            <thead>
                                <tr>
                                    <th class="text-left">SR. #</th>
                                    <th class="text-left">YEAR</th>
                                    <th class="text-left">MONTH</th>
                                    <th class="text-left">DESCRIPTION</th>
                                    <th class="text-left">AMOUNT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(item, index) in form.items" :key="item.id">
                                    <tr>
                                        <td class="no" style="width:15%">
                                            <span> Item {{ index }} <button type="button" @click="removeItem(index)" class="ms-1 text-danger"><i class='bx bxs-trash'></i></button></span>
                                        </td>
                                        <td class="text-left" style="width:15%">
                                            <select v-model="item.year" class="form-control">
                                                <template v-for="year in years">
                                                    <option :value="year.value">{{ year.value }}</option>
                                                </template>
                                            </select>
                                        </td>
                                        <td class="text-left" style="width:25%">
                                            <select v-model="item.month" class="form-control">
                                                <template v-for="month in months">
                                                    <option :value="month.id">{{ month.name }}</option>
                                                </template>
                                            </select>
                                        </td>
                                        <td class="text-left" style="width:50%">
                                            <input type="text" class="form-control" v-model="item.description">
                                        </td>
                                        <td class="total" style="width:15%">
                                            <input type="number" class="form-control" v-model="item.amount" @keyup="getGrandTotal">
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3"></th>
                                    <th>TOTAL</th>
                                    <th>{{ format_number(form.total) }}</th>
                                </tr>
                            </tfoot>
                        </table>
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

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import Paginate from "@/Components/Paginate.vue";
import { ref, watch } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SuccessButton from "@/Components/SuccessButton.vue";
import ActionButton from "@/Components/ActionButton.vue";
import Create from "./Create.vue";
import Filter from "./Filter.vue";

const permission = usePage().props.can;

defineProps({
    expenses: Array,
    filter: Object,
});

const create_edit_ref = ref(null);
const edit = (expense) => {
    create_edit_ref.value.edit(expense)
};
const format_number = (number) => {
    return new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(number);
};

const deleteExpense = (expense_id) => {
    const form = useForm({
        expense_id: expense_id,
    });
    if (confirm('Are you sure you want to delete this Expense?')) {
        form.post(route("expense.delete"), {
            preserveScroll: true,
            onSuccess: (response) => {
                // closeModal();
            },
            onError: (errors) => {
                // console.log(errors)
            },
            onFinish: () => { },
        });
    }
};
</script>

<template>

    <Head title="Invoices" />

    <AuthenticatedLayout>
        <div class="page-wrapper">
            <div class="page-content">
                <!--breadcrumb-->
                <div class="page-breadcrumb d-sm-flex align-items-center mb-3">
                    <div class="breadcrumb-title pe-3">Manage Expenses</div>
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="javascript:;">
                                        <i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Expense List</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="ms-auto">
                        <Filter v-bind="$props"></Filter>
                        <Create v-bind="$props" ref="create_edit_ref"></Create>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="table-light">
                                    <tr>
                                        <th colspan="17" class="text-uppercase text-center text-lg">
                                            From "{{ filter['from_date'] }}" TO "{{ filter['to_date'] }}"
                                        </th>
                                    </tr>
                                    <tr class="text-uppercase">
                                        <th>SR #</th>
                                        <th>Year</th>
                                        <th>Month</th>
                                        <th>Expense Date</th>
                                        <th>No.of Items</th>
                                        <th>Total Amount</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-for="(expense, index) in expenses.data">
                                        <tr>
                                            <td>{{ ++index }}</td>
                                            <td>{{ expense.year }}</td>
                                            <td>{{ expense.month_name }}</td>
                                            <td>{{ expense.expense_at }}</td>
                                            <td>{{ expense.items_count }}</td>
                                            <td>${{ format_number(expense.total_amount) }}</td>
                                            <td>
                                                <a class="text-danger" href="#" @click="deleteExpense(expense.id)"
                                                    v-if="permission.expense_delete">
                                                    <i class="bx bx-trash"></i>
                                                </a>
                                                <ActionButton @click="edit(expense)" title="Edit" class="mr-1">
                                                    <i class="bx bx-edit"></i>
                                                </ActionButton>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="float-right">
                            <Paginate :links="expenses.links" />
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style src="@vueform/multiselect/themes/default.css"></style>
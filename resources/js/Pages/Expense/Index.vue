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
import moment from 'moment';

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

const format_date = (date) => {
    let parsedDate = moment(date);
    let formattedDate = parsedDate.format('YYYY-MM-DD');
    return formattedDate;
}
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
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th colspan="6" class="text-uppercase text-center text-lg">
                                            From "{{ filter['from_date'] }}" TO "{{ filter['to_date'] }}"
                                        </th>
                                    </tr>
                                    <tr class="text-uppercase">
                                        <th>SR #</th>
                                        <th>Expense Date</th>
                                        <th>Expense Description</th>
                                        <th>Total Amount</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(expense, index) in expenses.data">
                                        <td>{{ (expenses.current_page - 1) * expenses.per_page + index + 1 }}</td>
                                        <td>{{ format_date(expense.expense_at) }}</td>
                                        <td>
                                            <table class="table table-bordered table-secondary" style="font-size: 12px;">
                                                <tbody>
                                                    <tr v-for="item in expense.expense_items" :key="item.id">
                                                        <td style="width: 300px;">{{ item.description }}</td>
                                                        <td style="width: 100px;">{{ format_number(item.amount) }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td>{{ format_number(expense.total_amount) }}</td>
                                        <td>
                                            <ActionButton @click="edit(expense)" title="Edit" class="mr-1">
                                                <i class="bx bx-edit"></i>
                                            </ActionButton>
                                            <a class="text-danger text-lg" href="#" @click="deleteExpense(expense.id)"
                                                v-if="permission.expense_delete">
                                                <i class="bx bx-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
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
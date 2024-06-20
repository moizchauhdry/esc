<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, usePage, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import Filter from "@/Pages/Ledger/Filter.vue";
import Payment from "@/Pages/Ledger/Payment.vue";
import EditLedger from "@/Pages/Ledger/EditLedger.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const role = usePage().props.auth.user.roles[0];

defineProps({
    ledgers: Object,
    companies: Object,
    filter: Object,
    balance: Object,
});

const format_number = (number) => {
    return new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(number);
};

const deleteLedger = (LedgerId) => {
    const form = useForm({
        ledger_id: LedgerId,
    });
  if (confirm('Are you sure you want to delete this Ledger?')) {
    form.post(route("ledger.delete"), {
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

const create_edit_ref = ref(null);
const edit = (ledger) => {
    create_edit_ref.value.edit(ledger)
};
</script>

<style src="@vueform/multiselect/themes/default.css"></style>

<template>

    <Head title="Ledgers" />

    <AuthenticatedLayout>
        <div class="page-wrapper">
            <div class="page-content">
                <!--breadcrumb-->
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <div class="breadcrumb-title pe-3">Invoice Management</div>
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="javascript:;">
                                        <i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Ledger List</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="ms-auto">
                        <EditLedger ref="create_edit_ref"></EditLedger>
                    </div>

                    <div class="ms-auto">
                        <Payment v-if="role.id !=2" v-bind="$props"></Payment>
                        <Filter v-bind="$props"></Filter>
                        <a :href="route('ledger.print', filter)" title="Print" class="ms-1" target="_blank">
                            <PrimaryButton>
                                <i class='bx bxs-printer text-white'></i>
                            </PrimaryButton>
                        </a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="d-lg-flex align-items-center mb-4 gap-3">
                            <div class="position-relative">
                                <input type="text" class="form-control ps-5 radius-30" placeholder="Search Invoice">
                                <span class="position-absolute top-50 product-show translate-middle-y"><i
                                        class="bx bx-search"></i></span>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered ledger-table table-sm" style="font-size:12px">
                                <thead class="table-light">
                                    <tr>
                                        <th colspan="12" style="text-align: center">
                                            {{ filter['company_name'] ?? 'EXPRESS SAVER CARGO' }} <br>
                                            CURR: PKR/RS
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="12" style="text-align: center">General Ledger From
                                            {{ filter['from'] }} to
                                            {{ filter['to'] }}</th>
                                    </tr>
                                    <tr>
                                        <th>Date</th>
                                        <th>Airline</th>
                                        <th>Particulars</th>
                                        <th>Orig</th>
                                        <th>Dest</th>
                                        <th>Pieces</th>
                                        <th>Weight</th>
                                        <th>Invoice ID</th>
                                        <th>Comments</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        <th>Balance</th>
                                        <th>D/C</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-for="(ledger, index) in ledgers.data">
                                        <tr>
                                            <td>{{ ledger.created_at }}</td>
                                            <td>{{ ledger.invoice?.carrier }}</td>
                                            <td>{{ ledger.invoice?.mawb_no }}</td>
                                            <td>{{ ledger.invoice?.sender }}</td>
                                            <td>{{ ledger.invoice?.destination }}</td>
                                            <td>{{ ledger.invoice?.quantity }}</td>
                                            <td>{{ ledger.invoice?.weight }}</td>
                                            <td>{{ ledger.invoice?.id }}</td>
                                            <td>{{ ledger.comments }}</td>
                                            <td>{{ format_number(ledger.debit) }}</td>
                                            <td>{{ format_number(ledger.credit) }}</td>
                                            <td>{{ format_number(ledger.balance) }}</td>
                                            <td>{{ ledger.credit > 0 ? 'CR': 'DR' }}</td>
                                            <td>
                                                <button @click="edit(ledger)"><i class="bx bx-edit"></i></button>
                                                <button @click="deleteLedger(ledger.id)"><i class="bx bx-trash"></i></button></td>
                                        </tr>
                                    </template>
                                    <tr>
                                        <th colspan="8" class="text-right">Total</th>
                                        <th>{{ format_number(balance.debit_total) }}</th>
                                        <th>{{ format_number(balance.credit_total) }}</th>
                                        <th>{{ format_number(balance.balance_total) }}</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>

</template>
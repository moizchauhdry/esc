<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, usePage, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import Filter from "@/Pages/Ledger/Filter.vue";
import Payment from "@/Pages/Ledger/Payment.vue";
import Balance from "@/Pages/Ledger/Balance.vue";
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
                        <Balance v-if="role.id != 2" v-bind="$props"></Balance>

                        <Payment v-if="role.id != 2" v-bind="$props"></Payment>
                        
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
                        <!-- <div class="d-lg-flex align-items-center mb-4 gap-3">
                            <div class="position-relative">
                                <input type="text" class="form-control ps-5 radius-30" placeholder="Search Invoice">
                                <span class="position-absolute top-50 product-show translate-middle-y"><i
                                        class="bx bx-search"></i></span>
                            </div>
                        </div> -->
                        <div class="table-responsive">
                            <table class="table table-bordered ledger-table table-sm" style="font-size:12px">
                                <thead class="table-light">
                                    <tr>
                                        <th colspan="12" style="text-align: center">
                                            {{ filter['company_name'] ?? 'EXPRESS SAVER CARGO' }} |
                                            CURRENCY: PKR/RS
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="12" style="text-align: center" class="text-uppercase">General Ledger From
                                            {{ filter['from'] }} to
                                            {{ filter['to'] }}</th>
                                    </tr>
                                    <tr>
                                        <th class="px-2">Company</th>
                                        <th class="px-2">Ledger at</th>
                                        <th class="px-2">Airline</th>
                                        <th class="px-2">MAWB #</th>
                                        <th class="px-2">Orig</th>
                                        <th class="px-2">Dest</th>
                                        <th class="px-2">Pieces</th>
                                        <th class="px-2">Weight</th>
                                        <th class="px-2">Invoice ID</th>
                                        <th class="px-2">Debit</th>
                                        <th class="px-2">Credit</th>
                                        <th class="px-2">Balance</th>
                                        <th class="px-2">D/C</th>
                                        <th class="px-2"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-for="(ledger, index) in ledgers.data">
                                        <tr>
                                            <td class="px-2">{{ ledger.company_name }}</td>
                                            <td class="px-2">{{ ledger.ledger_at }}</td>
                                            <template v-if="ledger.amount_type == 1">
                                                <td class="px-2">{{ ledger.invoice?.carrier }}</td>
                                                <td class="px-2">{{ ledger.invoice?.mawb_no }}</td>
                                                <td class="px-2">{{ ledger.invoice?.sender }}</td>
                                                <td class="px-2">{{ ledger.invoice?.destination }}</td>
                                                <td class="px-2">{{ ledger.invoice?.quantity }}</td>
                                                <td class="px-2">{{ ledger.invoice?.weight }}</td>
                                                <td class="px-2">{{ ledger.invoice?.id }}</td>
                                            </template>
                                            <template v-if="ledger.amount_type == 2 || ledger.amount_type == 3">
                                                <td colspan="7">{{ ledger.comments }}</td>
                                            </template>
                                            <td class="px-2">{{ format_number(ledger.debit) }}</td>
                                            <td class="px-2">{{ format_number(ledger.credit) }}</td>
                                            <td class="px-2">{{ format_number(ledger.balance) }}</td>
                                            <td class="px-2">
                                                {{ ledger.amount_type == 1 ? 'Dr' : '' }}
                                                {{ ledger.amount_type == 2 ? 'Cr' : '' }}
                                            </td>
                                            <td class="px-2">
                                                <template v-if="ledger.amount_type == 2 || ledger.amount_type == 3">
                                                    <div class="d-flex order-actions">
                                                        <template v-if="ledger.amount_type == 2">
                                                            <a href="#" class="mx-1" @click="edit(ledger)">
                                                                <i class="bx bx-edit"></i></a>
                                                        </template>
                                                        <a href="#" @click="deleteLedger(ledger.id)">
                                                            <i class="bx bx-trash"></i>
                                                        </a>
                                                    </div>
                                                </template>
                                            </td>
                                        </tr>
                                    </template>
                                    <tr>
                                        <th colspan="9" class="text-right">Total</th>
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
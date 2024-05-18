<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, usePage, useForm } from "@inertiajs/vue3";
import SearchLedger from "@/Pages/Invoice/SearchLedger.vue";

defineProps({
    invoices: Object,
    companies: Object,
    filter: Object
});


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
                        <SearchLedger v-bind="$props"></SearchLedger>
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
                            <table class="table table-bordered ledger-table">
                                <thead class="table-light">
                                    <tr>
                                        <th colspan="12" style="text-align: center">
                                            {{ filter['company_name'] ?? 'EXPRESS SAVER CARGO' }} <br>
                                            CURR: PKR/RS
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="12" style="text-align: center">General Ledger From {{filter['from']}} to
                                            {{filter['to']}}</th>
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
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        <th>Balance</th>
                                        <th>D/C</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-for="(invoice, index) in invoices.data">
                                        <tr>
                                            <td>{{ invoice.data.created_at }}</td>
                                            <td>{{ invoice.data.carrier }}</td>
                                            <td>{{ invoice.data.mawb_no }}</td>
                                            <td>{{ invoice.data.sender }}</td>
                                            <td>{{ invoice.data.destination }}</td>
                                            <td>{{ invoice.data.quantity }}</td>
                                            <td>{{ invoice.data.weight }}</td>
                                            <td>{{ invoice.data.id }}</td>
                                            <td>778,110</td>
                                            <td>1,345,764</td>
                                            <td>3,345,764</td>
                                            <td>DR</td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>

</template>
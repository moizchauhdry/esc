<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import Paginate from "@/Components/Paginate.vue";
import ActionButton from "@/Components/ActionButton.vue";
import { ref, watch } from "vue";
import EditSaleReport from "./Partial/EditSaleReport.vue";
import FilterSaleReport from "./Partial/FilterSaleReport.vue";

defineProps({
    invoices: Array,
    carriers: Array,
});

const edit_sale_report_ref = ref(null);
const edit = (invoice) => {
    edit_sale_report_ref.value.edit(invoice)
};
</script>

<template>

    <Head title="Invoices" />

    <AuthenticatedLayout>
        <div class="page-wrapper">
            <div class="page-content">
                <!--breadcrumb-->
                <div class="page-breadcrumb d-sm-flex align-items-center mb-3">
                    <div class="breadcrumb-title pe-3">Manage Reports</div>
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="javascript:;">
                                        <i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Sales Report</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="ms-auto">
                        <EditSaleReport ref="edit_sale_report_ref"></EditSaleReport>
                        <FilterSaleReport v-bind="$props"></FilterSaleReport>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table">
                                <thead class="table-light">
                                    <tr>
                                        <th>SR #</th>
                                        <th>Invoice ID</th>
                                        <th>AWB NO</th>
                                        <th>Pieces</th>
                                        <th>Weight</th>
                                        <th>Sender</th>
                                        <th>Destination</th>
                                        <th>Due Carrier</th>
                                        <th>Net Rate</th>
                                        <th>Net Payable</th>
                                        <th>Invoice at</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-for="(invoice, index) in invoices.data">
                                        <tr>
                                            <td>{{ ++index }}</td>
                                            <td>{{ invoice.id }}</td>
                                            <td>{{ invoice.invoice.mawb_no }}</td>
                                            <td>{{ invoice.invoice.quantity }}</td>
                                            <td>{{ invoice.invoice.weight }}</td>
                                            <td>{{ invoice.invoice.sender }}</td>
                                            <td>{{ invoice.invoice.destination }}</td>
                                            <td>{{ invoice.invoice.due_carrier ?? "-"}}</td>
                                            <td>{{ invoice.invoice.net_rate ?? "-"}}</td>
                                            <td>{{ invoice.invoice.net_payable ?? "-"}}</td>
                                            <td>{{ invoice.invoice_at ?? "-"}}</td>

                                            <td style="width: 10px;">
                                                <div class="d-flex order-actions">
                                                    <ActionButton @click="edit(invoice)" title="Edit" class="mr-1">
                                                        <i class="bx bx-edit"></i>
                                                    </ActionButton>
                                                </div>
                                            </td>
                                        </tr>
                                    </template>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="float-right">
                            <Paginate :links="invoices.links" />
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style src="@vueform/multiselect/themes/default.css"></style>
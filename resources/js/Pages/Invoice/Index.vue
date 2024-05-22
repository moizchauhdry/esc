<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, usePage } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";

defineProps({
    invoices: Object,
    contact: Object
});

</script>

<template>

    <Head title="Invoices" />

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
                                <li class="breadcrumb-item active" aria-current="page">Invoice List</li>
                            </ol>
                        </nav>
                    </div>

                    <div class="ms-auto">
                        <Link :href="route('invoice.create')">
                        <PrimaryButton>Add Invoice</PrimaryButton>
                        </Link>
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
                            <table class="table">
                                <thead class="table-light">
                                    <tr>
                                        <th>Invoice #</th>
                                        <th>Company</th>
                                        <th>Shipper</th>
                                        <th>Consignee</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-for="(invoice, index) in invoices.data">
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <!-- <div>
                                                        <input class="form-check-input me-3" type="checkbox" value=""
                                                            aria-label="...">
                                                    </div> -->
                                                    <div class="ms-2">
                                                        <h6 class="mb-0 font-14">000{{ invoice.id }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                {{ invoice.company_name }}
                                            </td>
                                            <td>
                                                <b>Account #:</b> {{ invoice.data.shipper_id }} <br>
                                                <b>Name:</b> {{ invoice.consignee_name }} <br>
                                            </td>
                                            <td>
                                                <b>Account #:</b> {{ invoice.data.consignee_id }} <br>
                                                <b>Name:</b> {{ invoice.consignee_name }} <br>
                                            </td>
                                            <td>
                                                <div
                                                    class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3">
                                                    <i class='bx bxs-circle me-1'></i>Done
                                                </div>
                                            </td>
                                            <td>PKR {{ invoice.data.total }}</td>
                                            <td>{{ invoice.created_at }}</td>
                                            <td>
                                                <div class="d-flex order-actions">

                                                    <Link :href="route('invoice.edit', invoice.id)">
                                                    <i class='bx bxs-edit'></i>
                                                    </Link>

                                                    <a href="#" title="Detail" class="ms-1"><i
                                                            class='bx bxs-collection'></i></a>

                                                    <a :href="route('invoice.print', invoice.id)" title="Print"
                                                        class="ms-1" target="_blank"><i class='bx bxs-printer'></i></a>

                                                    <a href="#" title="Delete" class="ms-1 text-danger"><i
                                                            class='bx bxs-trash'></i></a>
                                                </div>
                                            </td>
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
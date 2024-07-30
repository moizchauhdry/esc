<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Paginate from "@/Components/Paginate.vue";
import SuccessButton from "@/Components/SuccessButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import Multiselect from "@vueform/multiselect";

defineProps({
    invoices: Object,
    contact: Object,
    page_type: String,
    filter: Object,
    companies: Array,
    shippers: Array,
    consignees: Array,
});

const permission = usePage().props.can;
const page_type = usePage().props.page_type;

const format_number = (number) => {
    return new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(number);
};

const form = useForm({
    search_key: 1,
    search_value: "",
});

const search = () => {
    if (page_type == 'invoice') {
        var form_route = route("invoice.index");
    } else {
        var form_route = route("shipment.index");
    }

    form.post(form_route, {
        preserveScroll: true,
        onSuccess: (response) => {
            //
        },
        onError: (errors) => {
            //
        },
        onFinish: () => { },
    });
};

const clearSearch = () => {
    form.search_value = "";
};

const resetFilter = () => {
    form.search_key = 1;
    form.search_value = "";
};

</script>

<template>
    <Head title="Invoices" />

    <AuthenticatedLayout>
        <div class="page-wrapper">
            <div class="page-content">
                <!--breadcrumb-->
                <div class="page-breadcrumb d-sm-flex align-items-center mb-3">
                    <div class="breadcrumb-title pe-3">Manage Shipments</div>
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="javascript:;">
                                        <i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page"><span class="text-capitalize">{{
                                    page_type }}</span> List</li>
                            </ol>
                        </nav>
                    </div>

                    <div class="ms-auto" v-if="page_type == 'shipment' && permission.shipment_create">
                        <Link :href="route('shipment.create')">
                        <PrimaryButton>Add {{ page_type }}</PrimaryButton>
                        </Link>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form @submit.prevent="search">
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <select v-model="form.search_key" class="form-control" @change="clearSearch">
                                        <option value="1">AWB #</option>
                                        <option value="2">Shipment #</option>
                                        <option value="3">Company</option>
                                        <option value="4">Shipper</option>
                                        <option value="5">Consignee</option>
                                    </select>
                            </div>

                            <template v-if="form.search_key == 1 || form.search_key == 2">
                                    <div class="col-md-3">
                                        <input type="search" v-model="form.search_value" class="form-control"
                                            placeholder="Search">
                                    </div>
                                </template>

                                <div class="col-md-3" v-if="form.search_key == 3">
                                    <InputLabel for="" value="Company" class="mb-1" />
                                    <Multiselect :searchable="true" v-model="form.search_value" :options="companies">
                                    </Multiselect>
                                </div>

                                <div class="col-md-3" v-if="form.search_key == 4">
                                    <InputLabel for="" value="Shipper" class="mb-1" />
                                    <Multiselect :searchable="true" v-model="form.search_value" :options="shippers">
                                    </Multiselect>
                                </div>

                                <div class="col-md-3" v-if="form.search_key == 5">
                                    <InputLabel for="" value="Consignee" class="mb-1" />
                                    <Multiselect :searchable="true" v-model="form.search_value" :options="consignees">
                                    </Multiselect>
                                </div>

                                <div class="col-md-3">
                                    <SuccessButton class="px-4 py-1" :class="{ 'opacity-25': form.processing }"
                                        :disabled="form.processing">
                                        Search
                                    </SuccessButton>
                                    <DangerButton class="px-4 py-1" @click="resetFilter" :disabled="form.processing">
                                        Reset
                                    </DangerButton>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5px;">SR #</th>
                                        <th style="width: 10px;">AWB/Shipment #</th>
                                        <th style="width: 5px;">Company</th>
                                        <th style="width: 10px;">Shipper/Consignee</th>

                                        <th style="width: 10px;" v-if="page_type == 'shipment'">Departure</th>
                                        <th style="width: 10px;" v-if="page_type == 'shipment'">Landing</th>

                                        <th style="width: 10px;" v-if="page_type == 'invoice'">Total</th>
                                        <th style="width: 10px;" v-if="page_type == 'invoice'">Invoice Date</th>

                                        <th style="width: 10px;">Status</th>
                                        <th style="width: 10px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-for="(invoice, index) in invoices.data">
                                        <tr>
                                            <td style="width: 10px;">
                                                <div class="d-flex align-items-center">
                                                    <!-- <div>
                                                                                                    <input class="form-check-input me-3" type="checkbox" value="1"
                                                                                                        aria-label="...">
                                                                                                </div> -->
                                                    {{ ++index }}
                                                </div>
                                            </td>
                                            <td style="width: 10px;">
                                                <b>AWB #:</b> {{ invoice.mawb_no }} <br>
                                                <b>Shipment #:</b> {{ invoice.id }} <br>
                                            </td>
                                            <td>{{ invoice.company_name }}</td>

                                            <td style="width: 10px;">
                                                <!-- <b>Account #:</b> {{ invoice.shipper_id }} <br> -->
                                                <b>Shipper:</b> {{ invoice.shipper_name }} <br>

                                                <!-- <b>Account #:</b> {{ invoice.consignee_id }} <br> -->
                                                <b>Consignee:</b> {{ invoice.consignee_name }} <br>
                                            </td>

                                        <td style="width: 10px;" v-if="page_type == 'shipment'">
                                            <b>Port:</b> {{ invoice.sender }} <br>
                                                <b>Date:</b> {{ invoice.departure_at }}
                                            </td>
                                            <td style="width: 10px;" v-if="page_type == 'shipment'">
                                                <b>Port:</b> {{ invoice.destination }} <br>
                                                <b>Date:</b> {{ invoice.landing_at }}
                                            </td>

                                            <td style="width: 10px;" v-if="page_type == 'invoice'">PKR {{
                                                format_number(invoice.total) }}
                                            </td>
                                            <td style="width: 10px;" v-if="page_type == 'invoice'">{{ invoice.invoice_at
                                            }}</td>

                                            <td style="width: 10px;">

                                                <template v-if="invoice.status_id == 1">
                                                    <div
                                                        class="badge text-warning bg-light-warning p-2 text-uppercase px-2">
                                                        <i class='bx bxs-circle me-1'></i>Pending
                                                    </div>
                                                </template>

                                                <template v-if="invoice.status_id == 2">
                                                    <div
                                                        class="badge text-success bg-light-success p-2 text-uppercase px-2">
                                                        <i class='bx bxs-circle me-1'></i>Approved
                                                    </div>
                                                </template>

                                                <template v-if="invoice.status_id == 3">
                                                    <div class="badge text-danger bg-light-danger p-2 text-uppercase px-2">
                                                        <i class='bx bxs-circle me-1'></i>Rejected
                                                    </div>
                                                </template>
                                            </td>

                                            <td style="width: 10px;">
                                                <div class="d-flex order-actions">

                                                    <template v-if="page_type == 'shipment' && permission.shipment_update">
                                                        <Link :href="route('shipment.edit', invoice.id)">
                                                        <i class='bx bxs-edit'></i>
                                                        </Link>
                                                    </template>

                                                    <template v-if="page_type == 'invoice' && permission.invoice_update">
                                                        <Link :href="route('invoice.edit', invoice.id)">
                                                        <i class='bx bxs-edit'></i>
                                                        </Link>
                                                    </template>

                                                    <Link :href="route('invoice.detail', invoice.id)" title="Detail"
                                                        class="ms-1">
                                                    <i class='bx bxs-collection'></i></Link>

                                                    <template v-if="page_type == 'invoice' && permission.invoice_print">
                                                        <a :href="route('invoice.print', invoice.id)" title="Print"
                                                            class="ms-1" target="_blank"><i class='bx bxs-printer'></i></a>
                                                    </template>

                                                    <!-- <template v-if="page_type == 'shipment'">
                                                                                                                                        <a href="#" title="Delete" class="ms-1 text-danger"><i
                                                                                                                                                class='bx bxs-trash'></i></a>
                                                                                                                                    </template> -->
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
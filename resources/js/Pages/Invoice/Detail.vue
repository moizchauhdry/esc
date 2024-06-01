<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, usePage, useForm } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { ref } from "vue";

defineProps({
    invoice: Object,
    invoice_files: Array,
});

const invoice = usePage().props.invoice;
const permission = usePage().props.can;

const format_number = (number) => {
    return new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(number);
};

const form = useForm({
    invoice_id: invoice.id,
    file: "",
});

const handle_file_change = (event) => {
    const selected_file = event.target.files[0];
    form.file = selected_file;
};

const upload_file = () => {
    form.post(route("invoice.upload"), {
        preserveScroll: true,
        onSuccess: () => { },
        onError: () => error(),
        onFinish: () => { },
    });
};

</script>

<template>

    <Head title="Invoices" />

    <AuthenticatedLayout>
        <div class="page-wrapper">
            <div class="page-content">
                <!--breadcrumb-->
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <div class="breadcrumb-title pe-3">Manage Shipments</div>
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="javascript:;">
                                        <i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page"><span
                                        class="text-capitalize">Detail</span></li>
                            </ol>
                        </nav>
                    </div>

                    <div class="ms-auto">
                        <!-- BACK BUTTON HERE-->
                        <Link :href="route('invoice.index')">
                        <PrimaryButton>Back</PrimaryButton>
                        </Link>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr class="bg-primary text-white">
                                <th class="text-uppercase p-1" colspan="8"><div>Invoice Detail</div></th>
                            </tr>
                            <tr>
                                <th>Invoice #</th>
                                <td>{{ invoice.id }}</td>
                                <th>Company</th>
                                <td>{{ invoice?.company?.name }}</td>

                                <th>Shipper</th>
                                <td>{{ invoice?.shipper?.name }}</td>
                                <th>Consignee</th>
                                <td>{{ invoice?.consignee?.name }}</td>
                            </tr>
                            <tr class="bg-primary text-white">
                                <th class="text-uppercase p-1" colspan="8"><div>Invoice Files</div></th>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <div>
                                        <input type="file" class="form-control"  @change="handle_file_change" />

                                    </div>
                                </td>
                                <td colspan="3">
                                    <div class="d-flex order-actions">

                                        <PrimaryButton @click="upload_file">Upload File</PrimaryButton>
                                    </div>
                                </td>
                            </tr>

                            <template v-if="invoice.uploads.length > 0">
                                <tr class="text-uppercase">
                                    <th colspan="8" class="bg-dark text-white">
                                        <div>
                                            Attachments
                                        </div>
                                    </th>
                                </tr>
                                <tr class="text-uppercase">
                                    <th>
                                        <div>
                                            SR. #
                                        </div>
                                    </th>
                                    <th colspan="6">
                                        <div>
                                            URL
                                        </div>
                                    </th>
                                </tr>
                                <tr v-for="upload, index in invoice.uploads" :key="upload.id">
                                    <td>{{ ++index }}</td>
                                    <td colspan="6">
                                        <div class="text-underline">
                                            <a :href="'/storage/' + upload.url" target="_blank"
                                                rel="noopener noreferrer" class="btn btn-primay">
                                                {{ upload.url }}
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>

</template>
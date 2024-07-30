<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, usePage, useForm } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { ref, onMounted } from "vue";
import Paginate from "@/Components/Paginate.vue";
import DeleteInvoiceUpload from './DeleteInvoiceUpload.vue';
import InputError from "@/Components/InputError.vue";
import InvoiceDetail from './Partial/InvoiceDetail.vue';

const props = defineProps({
    invoice: Object,
    invoice_uploads: Array,
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
        onError: () => {
            // console.log(usePage().props.flash)
        },
        onFinish: () => { },
    });
};

onMounted(() => {
    // 
});
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
                        <InvoiceDetail v-bind="$props"></InvoiceDetail>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
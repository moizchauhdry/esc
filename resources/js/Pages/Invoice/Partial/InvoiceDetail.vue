<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, usePage, useForm } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { ref, onMounted, computed } from "vue";
import Paginate from "@/Components/Paginate.vue";
import DeleteInvoiceUpload from '../DeleteInvoiceUpload.vue';
import InputError from "@/Components/InputError.vue";

const props = defineProps({
    invoice: Object,
    invoice_uploads: Array,
});

// const invoice = usePage().props.invoice;
const permission = usePage().props.can;

const format_number = (number) => {
    return new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(number);
};

const form = useForm({
    // invoice_id: invoice_id,
    invoice_id: "",
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

const invoiceId = computed(() => props.invoice?.id || null);
form.invoice_id = invoiceId.value;

</script>

<template>
    <table class="table table-bordered">
        <tbody>
            <tr class="bg-primary text-white">
                <th class="text-uppercase p-1" colspan="8">Invoice Detail</th>
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
                <th class="text-uppercase p-1" colspan="8">
                    <div>Invoice Files</div>
                </th>
            </tr>
            <tr v-if="permission.invoice_upload">
                <td colspan="5">
                    <div>
                        <input type="file" class="form-control" @change="handle_file_change" />
                        <InputError :message="form.errors.file" />
                    </div>
                </td>
                <td colspan="3">
                    <div class="d-flex order-actions">
                        <PrimaryButton @click="upload_file">Upload File</PrimaryButton>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm">
        <tbody>
            <template v-if="invoice_uploads.data.length > 0">
                <tr class="text-uppercase">
                    <th colspan="8" class="bg-dark text-white">Attachments</th>
                </tr>
                <tr class="text-uppercase">
                    <th>SR. #</th>
                    <th>File ID</th>
                    <th colspan="6">URL</th>
                    <th></th>
                </tr>
                <tr v-for="upload, index in invoice_uploads.data" :key="upload.id">
                    <td>{{ ++index }}</td>
                    <td>{{ upload.id }}</td>
                    <td colspan="6">
                        <div class="text-underline">
                            <a :href="'/storage/' + upload.url" target="_blank" rel="noopener noreferrer"
                                class="btn btn-primay">
                                {{ upload.url }}
                            </a>
                        </div>
                    </td>
                    <td>
                        <DeleteInvoiceUpload :upload_id="upload.id" v-if="permission.invoice_upload_destroy">
                        </DeleteInvoiceUpload>
                    </td>
                </tr>
            </template>
            <template v-else>
                <tr>
                    <th class="p-2">No record found.</th>
                </tr>
            </template>
        </tbody>
    </table>
    </div>
    <div>
        <Paginate :links="invoice_uploads.links" :scroll="true" />
    </div>
</template>

<script setup>
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import Modal from "@/Components/Modal.vue";
import InvoiceDetail from "@/Pages/Invoice/Partial/InvoiceDetail.vue";

defineProps({
    companies: Array,
    balance: Array,
});

const modal = ref(false);

const error = () => {
    // 
};

const form = useForm({
    invoice_id: "",
    invoice: "",
    invoice_uploads: "",
});

const invoicedetail = (ledger) => {

    form.invoice_id = ledger.invoice.id;

    axios.post(route('ledger.fetch-ledger-invoice'), form)
        .then(({ data }) => {
            form.invoice = data.invoice
            form.invoice_uploads = data.invoice_uploads

            modal.value = true;

        })
        .catch(error => {
            // 
        });
};

const closeModal = () => {
    modal.value = false;
};

defineExpose({ invoicedetail: (ledger) => invoicedetail(ledger) });

</script>

<template>
    <Modal :show="modal" @close="closeModal">
        <div class="p-4">
            <InvoiceDetail :invoice="form.invoice" :invoice_uploads="form.invoice_uploads"></InvoiceDetail>
        </div>
    </Modal>

    <!-- <div class="modal fade show" style="display: block;" id="exampleFullScreenModal" tabindex="-1" aria-hidden="true"
            v-if="modal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ledger - Invoice Deatil #{{ form.invoice.id }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            @click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <InvoiceDetail :invoice="form.invoice" :invoice_uploads="form.invoice_uploads"></InvoiceDetail>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            @click="closeModal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div> -->
</template>

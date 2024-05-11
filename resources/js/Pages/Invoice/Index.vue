<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import { ref } from "vue";

defineProps({
    invoices: Object,
});

const invoice_modal = ref(false);
const edit_mode = ref(false);

const form = useForm({
    invoice_id: "",
    shipper_id: "",
    consignee_id: "",
    shipper_name: "",
    shipper_address: "",
    consignee_id: "",
    consignee_name: "",
    consignee_address: "",
    carrier: "",
    mawb_no: "",
    quantity: "",
    weight: "",
    commodity: "",
    afc_rate: "",
    sender: "",
    destination: "",
    consignment_no: "",
    departure_airport: "",
    issued_by: "",
    created_by: ""
});

const create = () => {
    invoice_modal.value = true;
    edit_mode.value = false;
};

const submit = () => {
    form.post(route("invoice.create"), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => error(),
        onFinish: () => { },
    });
};

const edit = (invoice) => {
    invoice_modal.value = true;
    edit_mode.value = true;

    form.invoice_id = invoice.id;
    form.shipper_id = invoice.shipper_id;
    form.shipper_name = invoice.shipper_name;
    form.shipper_address = invoice.shipper_address;
    form.consignee_id = invoice.consignee_id;
    form.consignee_name = invoice.consignee_name;
    form.consignee_address = invoice.consignee_address;

    form.carrier = invoice.carrier;
    form.mawb_no = invoice.mawb_no;
    form.quantity = invoice.quantity;
    form.weight = invoice.weight;
    form.commodity = invoice.commodity;
    form.afc_rate = invoice.afc_rate;
    form.sender = invoice.sender;
    form.destination = invoice.destination;
    form.consignment_no = invoice.consignment_no;
    form.departure_airport = invoice.departure_airport;
    form.issued_by = invoice.issued_by;
    form.created_by = invoice.created_by;
};

const update = () => {
    form.post(route("invoice.update"), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => error(),
        onFinish: () => { },
    });
};

const error = () => {
    // 
};

const closeModal = () => {
    invoice_modal.value = false;
    form.reset();
};
</script>


<template>

    <Head title="Invoices" />

    <AuthenticatedLayout>
        <!--start page wrapper -->
        <div class="page-wrapper">
            <div class="page-content">
                <!--breadcrumb-->
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <div class="breadcrumb-title pe-3">User Management</div>
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="javascript:;">
                                        <i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">User List</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="ms-auto">
                        <!-- CREATE & UPDATE MODAL -->
                        <div class="col">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#exampleLargeModal" @click="create"><i
                                    class="bx bx-plus"></i>Add</button>
                            <div class="modal fade show" id="exampleLargeModal" tabindex="-1" aria-hidden="true"
                                style="display: block;" v-if="invoice_modal">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <form @submit.prevent="edit_mode ? update() : submit()">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Invoice</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close" @click="closeModal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row g-2">
                                                    <div class="col-md-6">
                                                        <label for="input13" class="form-label">Shipper Name</label>
                                                        <input type="text" class="form-control"
                                                            v-model="form.shipper_name">
                                                        <InputError :message="form.errors.shipper_name" />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="input13" class="form-label">Shipper Address</label>
                                                        <input type="text" class="form-control"
                                                            v-model="form.shipper_address">
                                                        <InputError :message="form.errors.shipper_address" />
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="input13" class="form-label">Consignee Name</label>
                                                        <input type="text" class="form-control"
                                                            v-model="form.consignee_name">
                                                        <InputError :message="form.errors.consignee_name" />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="input13" class="form-label">Consignee
                                                            Address</label>
                                                        <input type="text" class="form-control"
                                                            v-model="form.consignee_address">
                                                        <InputError :message="form.errors.consignee_address" />
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="input13" class="form-label">Carrier</label>
                                                        <input type="text" class="form-control" v-model="form.carrier">
                                                        <InputError :message="form.errors.carrier" />
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="input13" class="form-label">MAWB No</label>
                                                        <input type="text" class="form-control" v-model="form.mawb_no">
                                                        <InputError :message="form.errors.mawb_no" />
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="input13" class="form-label">Quantity</label>
                                                        <input type="text" class="form-control" v-model="form.quantity">
                                                        <InputError :message="form.errors.quantity" />
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="input13" class="form-label">Weight</label>
                                                        <input type="text" class="form-control" v-model="form.weight">
                                                        <InputError :message="form.errors.weight" />
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="input13" class="form-label">Commodity</label>
                                                        <input type="text" class="form-control"
                                                            v-model="form.commodity">
                                                        <InputError :message="form.errors.commodity" />
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="input13" class="form-label">AFC Rate</label>
                                                        <input type="text" class="form-control" v-model="form.afc_rate">
                                                        <InputError :message="form.errors.afc_rate" />
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="input13" class="form-label">Sender</label>
                                                        <input type="text" class="form-control" v-model="form.sender">
                                                        <InputError :message="form.errors.sender" />
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="input13" class="form-label">Destination</label>
                                                        <input type="text" class="form-control"
                                                            v-model="form.destination">
                                                        <InputError :message="form.errors.destination" />
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="input13" class="form-label">Consignment No</label>
                                                        <input type="text" class="form-control"
                                                            v-model="form.consignment_no">
                                                        <InputError :message="form.errors.consignment_no" />
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="input13" class="form-label">Airport of
                                                            Departure</label>
                                                        <input type="text" class="form-control"
                                                            v-model="form.departure_airport">
                                                        <InputError :message="form.errors.departure_airport" />
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="input13" class="form-label">Issued By</label>
                                                        <input type="text" class="form-control"
                                                            v-model="form.issued_by">
                                                        <InputError :message="form.errors.issued_by" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary btn-sm"
                                                    data-bs-dismiss="modal" @click="closeModal">Close</button>

                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    {{ edit_mode ? 'Save & Update' : 'Save & Submit' }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Shipper</th>
                                        <th>Consignee</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-for="(invoice, index) in invoices.data">
                                        <tr>
                                            <td>{{ invoice.id }}</td>
                                            <td>{{ invoice.id }}</td>
                                            <td>{{ invoice.id }}</td>
                                            <td>{{ invoice.id }}</td>
                                            <td>{{ invoice.id }}</td>
                                            <td>
                                                <button type="button" @click="edit(invoice)" title="Edit"
                                                    clas="btn btn-primary"><i class="bx bx-edit"></i></button>
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
        <!--end page wrapper -->
    </AuthenticatedLayout>

</template>
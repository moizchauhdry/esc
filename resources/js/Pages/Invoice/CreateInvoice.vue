<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import { ref, watch } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import Address from "@/Pages/Invoice/Address.vue";
import { onMounted } from "vue";

const props = defineProps({
    address: Object,
    shippers: Array,
    consignees: Array,
});

const invoice_modal = ref(false);
const edit_mode = ref(false);

const form = useForm({
    invoice_id: "",

    shipper_id: "",
    shipper_account: "",
    shipper_address: "",

    consignee_id: "",
    consignee_account: "",
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
    created_by: "",

    total: 0,
    subtotal: 0,
    items: [],
});

const addItem = () => {
    form.items.push({
        particular: "",
        amount: 0,
    });
};

// const create = () => {
//     invoice_modal.value = true;
//     edit_mode.value = false;
//     addItem();
// };

const submit = () => {
    form.post(route("invoice.store"), {
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
    form.shipper_account = invoice.shipper_account;
    form.shipper_address = invoice.shipper_address;

    form.consignee_id = invoice.consignee_id;
    form.consignee_account = invoice.consignee_account;
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

    form.items = invoice.items;

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

const removeItem = (index) => {
    form.items.splice(index, 1);
    getGrandTotal();
};

const getGrandTotal = () => {
    form.subtotal = 0;
    form.items.forEach((item) => {
        form.subtotal += parseFloat(item.amount);
    });
    form.total = form.subtotal;
};

defineExpose({ edit: (invoice) => edit(invoice) });

onMounted(() => {
    console.log('mounted ')
});


const fetchAddress = () => {

    const fetch_address_form = useForm({
        id: form.shipper_id

    });

    fetch_address_form.post(route("address.fetch"), {
        preserveScroll: true,
        onSuccess: (response) => {
            var address = response.props.address;
            var concat_address = address.name + '\n' + address.address_1 + ', ' + address.address_2 + '\n' + address.city + ', ' + address.state + ', ' + address.country;

            if (address.type == 'shipper') {
                form.shipper_address = concat_address
            }

            if (address.type == 'consignee') {
                form.consignee_address = concat_address
            }
        },
        onError: (errors) => {
            console.log(errors)
        },
        onFinish: () => { },
    });
};

</script>

<template>

    <Head title="Invoices" />

    <AuthenticatedLayout>
        <div class="page-wrapper">
            <div class="page-content">
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <div class="breadcrumb-title pe-3">Invoice Management</div>
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="javascript:;">
                                        <i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Invoice Create</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="ms-auto">
                        <Address></Address>
                    </div>
                </div>

                <div class="card">
                    <form @submit.prevent="edit_mode ? update() : submit()">
                        <div class="card-body">
                            <div class="invoice overflow-auto">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <h6>Shipper</h6>
                                        <hr>
                                        <div class="row g-2">
                                            <div class="col-md-12">
                                                <label for="input13" class="form-label">Account
                                                    Number</label>
                                                <select class="form-control" v-model="form.shipper_id"
                                                    @change="fetchAddress()">
                                                    <template v-for="shipper in shippers" :key="shipper.id">
                                                        <option :value="shipper.id">{{ shipper.id }} - {{
                                                            shipper.address_1 }}
                                                        </option>
                                                    </template>
                                                </select>
                                                <InputError :message="form.errors.shipper_id" />
                                            </div>
                                            <div class="col-md-12">
                                                <label for="input11" class="form-label">Name &
                                                    Address</label>
                                                <textarea class="form-control" v-model="form.shipper_address"
                                                    rows="3"></textarea>
                                                <InputError :message="form.errors.shipper_address" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <h6>Consignee</h6>
                                        <hr>
                                        <div class="row g-2">
                                            <div class="col-md-12">
                                                <label for="input13" class="form-label">Account
                                                    Number</label>
                                                <select class="form-control" v-model="form.consignee_account">
                                                    <template v-for="consignee in consignees" :key="consignee.id">
                                                        <option :value="consignee.id">{{ consignee.id }} - {{
                                                            consignee.address_1 }}
                                                        </option>
                                                    </template>
                                                </select>
                                                <InputError :message="form.errors.consignee_account" />
                                            </div>
                                            <div class=" col-md-12">
                                                <label for="input13" class="form-label">Name &
                                                    Address</label>
                                                <textarea class="form-control" v-model="form.consignee_address"
                                                    rows="3"></textarea>
                                                <InputError :message="form.errors.consignee_address" />
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <h6>Sender/Destination</h6>
                                        <hr>
                                        <div class="row g-2">
                                            <div class="col-md-12">
                                                <label for="input13" class="form-label">Sender</label>
                                                <input type="text" class="form-control" v-model="form.sender">
                                                <InputError :message="form.errors.sender" />
                                            </div>
                                            <div class="col-md-12">
                                                <label for="input13" class="form-label">Destination</label>
                                                <input type="text" class="form-control" v-model="form.destination">
                                                <InputError :message="form.errors.destination" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-2 mb-3">
                                    <h6>Invoice</h6>
                                    <hr>
                                    <div class="col-md-4">
                                        <label for="input13" class="form-label">Carrier</label>
                                        <input type="text" class="form-control" v-model="form.carrier">
                                        <InputError :message="form.errors.carrier" />
                                    </div>

                                    <div class="col-md-4">
                                        <label for="input13" class="form-label">MAWB No</label>
                                        <input type="text" class="form-control" v-model="form.mawb_no">
                                        <InputError :message="form.errors.mawb_no" />
                                    </div>

                                    <div class="col-md-4">
                                        <label for="input13" class="form-label">Quantity</label>
                                        <input type="text" class="form-control" v-model="form.quantity">
                                        <InputError :message="form.errors.quantity" />
                                    </div>

                                    <div class="col-md-4">
                                        <label for="input13" class="form-label">Weight</label>
                                        <input type="text" class="form-control" v-model="form.weight">
                                        <InputError :message="form.errors.weight" />
                                    </div>

                                    <div class="col-md-4">
                                        <label for="input13" class="form-label">Commodity</label>
                                        <input type="text" class="form-control" v-model="form.commodity">
                                        <InputError :message="form.errors.commodity" />
                                    </div>

                                    <div class="col-md-4">
                                        <label for="input13" class="form-label">AFC Rate</label>
                                        <input type="text" class="form-control" v-model="form.afc_rate">
                                        <InputError :message="form.errors.afc_rate" />
                                    </div>

                                    <div class="col-md-4">
                                        <label for="input13" class="form-label">Consignment
                                            No</label>
                                        <input type="text" class="form-control" v-model="form.consignment_no">
                                        <InputError :message="form.errors.consignment_no" />
                                    </div>

                                    <div class="col-md-4">
                                        <label for="input13" class="form-label">Airport of
                                            Departure</label>
                                        <input type="text" class="form-control" v-model="form.departure_airport">
                                        <InputError :message="form.errors.departure_airport" />
                                    </div>

                                    <div class="col-md-4">
                                        <label for="input13" class="form-label">Issued By</label>
                                        <input type="text" class="form-control" v-model="form.issued_by">
                                        <InputError :message="form.errors.issued_by" />
                                    </div>
                                </div>

                                <table>
                                    <thead>
                                        <tr>
                                            <th>
                                                <button type="button" @click="addItem()"
                                                    class="ms-1 text-sucess btn btn-success btn-sm"><i
                                                        class='bx bx-plus'></i>Add
                                                    Item</button>
                                            </th>
                                            <th class="text-left" colspan="3">

                                                PARTICULARS
                                            </th>
                                            <th class="text-left">AMOUNT</th>
                                            <th class="text-left">TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <template v-for="(item, count, index) in form.items" :key="item.id">
                                            <tr>
                                                <td class="no">
                                                    <span>
                                                        Item #{{ ++count }}

                                                        <button type="button" @click="removeItem(index)"
                                                            class="ms-1 text-danger"><i
                                                                class='bx bxs-trash'></i></button>

                                                        <!-- <button type="button" class="btn btn-danger btn-sm"
                                                                        @click="removeItem(index)">
                                                                        Remove</button> -->
                                                    </span>

                                                </td>
                                                <td class="text-left" colspan="3">
                                                    <input type="text" class="form-control" v-model="item.particular">
                                                </td>
                                                <td class="text-left">
                                                    <input type="number" class="form-control" v-model="item.amount"
                                                        @keyup="getGrandTotal()">
                                                </td>

                                                <td class="total">${{ item.amount }}</td>
                                            </tr>
                                        </template>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td colspan="2">SUBTOTAL</td>
                                            <td>PKR {{ form.total.toFixed(2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td colspan="2">GRAND TOTAL</td>
                                            <td>PKR {{ form.total.toFixed(2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="flex items-center gap-2 mt-2">
                                <PrimaryButton :disabled="form.processing">
                                    {{ edit_mode ? "Update" : "Save" }}
                                </PrimaryButton>

                                <Link :href="route('invoice.index')">
                                <DangerButton :disabled="form.processing">
                                    Cancel
                                </DangerButton>
                                </Link>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
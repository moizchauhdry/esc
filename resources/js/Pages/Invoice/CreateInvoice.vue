<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import { ref, watch } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import { onMounted } from "vue";
import UserCreateEdit from "../User/CreateEdit.vue";
import axios from 'axios';
import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import InputLabel from "@/Components/InputLabel.vue";
import moment from 'moment';

const props = defineProps({
    invoice: Object,
    shippers: Array,
    consignees: Array,
    companies: Array,
    roles: Array,
    edit_mode: Boolean,
    page_type: String,
    templates: Array,
});

const invoice_modal = ref(false);
const invoice = usePage().props.invoice;
const edit_mode = usePage().props.edit_mode;
const page_type = usePage().props.page_type;

var selected_shipper = "";
var selected_consignee = "";

const form = useForm({
    invoice_id: invoice?.id,
    invoice_at: invoice?.invoice_at,
    company_id: invoice?.company_id,
    shipper_id: invoice?.shipper_id,
    consignee_id: invoice?.consignee_id,

    carrier: invoice?.carrier,
    mawb_no: invoice?.mawb_no,
    commodity: invoice?.commodity,
    quantity: invoice?.quantity,
    weight: invoice?.weight,
    afc_rate: invoice?.afc_rate,

    departure_at: invoice?.departure_at,
    landing_at: invoice?.landing_at,
    sender: invoice?.sender,
    destination: invoice?.destination,

    subtotal: 0,
    total: 0,

    items: invoice?.items,

    status_id: invoice?.status_id,
});

const addItem = () => {
    form.items.push({
        particular: "",
        amount: "",
        qty: 1,
        total: 0,
    });
};

const submit = () => {
    console.log(page_type)

    if (page_type == 'shipment') {

        if (edit_mode) {
            form.post(route("shipment.update"), {
                preserveScroll: true,
                onSuccess: () => closeModal(),
                onError: () => error(),
                onFinish: () => { },
            });
        } else {
            form.post(route("shipment.store"), {
                preserveScroll: true,
                onSuccess: () => closeModal(),
                onError: () => error(),
                onFinish: () => { },
            });
        }
    }

    else if (page_type == 'invoice') {
        form.post(route("invoice.update"), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
            onError: () => error(),
            onFinish: () => { },
        });
    } else {
        form.post(route("invoice.store"), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
            onError: () => error(),
            onFinish: () => { },
        });
    }
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
        form.subtotal += parseFloat(item.total);
    });
    form.total = form.subtotal;
};

const getLineTotal = (index) => {
    const item = form.items[index];
    const line_total = item.qty * item.amount;
    item.total = line_total;

    getGrandTotal();
};

const fetchShipper = (id) => {
    axios.get(`/users/fetch/shipper/${id}`)
        .then(({ data }) => {
            selected_shipper = data.selected_shipper
        });
};

const fetchConsignee = (id) => {
    axios.get(`/users/fetch/consignee/${id}`)
        .then(({ data }) => {
            selected_consignee = data.selected_consignee
        });
};

const create_edit_ref = ref(null);
const edit = (user) => {
    create_edit_ref.value.edit(user)
};

const format_number = (number) => {
    return new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(number);
};

const format_date = (date) => {
    let parsedDate = moment(date);
    // let newDate = parsedDate.add(5, 'hours');
    let formattedDate = parsedDate.format('YYYY-MM-DD HH:mm');
    return formattedDate;
}

watch(
    () => {
        if (form.departure_at) {
            form.departure_at = format_date(form.departure_at)
        }
        if (form.landing_at) {
            form.landing_at = format_date(form.landing_at)
        }
        if (form.invoice_at) {
            form.invoice_at = format_date(form.invoice_at)
        }
    }
);

onMounted(() => {
    if (!edit_mode) {
        form.items = [
            {
                particular: "",
                amount: 0,
                qty: 1,
                total: 0,
            },
        ];
    }

    if (edit_mode) {
        getGrandTotal();
    }

    fetchShipper(form.shipper_id);
    fetchConsignee(form.consignee_id);
});


const changeTemplate = (id) => {
    axios.get(`/templates/fetch/particulars/${id}`)
        .then(({ data }) => {
            form.items = data.particulars
        });
};
</script>

<template>
    <Head title="Invoices" />

    <AuthenticatedLayout>
        <div class="page-wrapper">
            <div class="page-content">
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <div class="breadcrumb-title pe-3">Manage Shipments</div>
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="javascript:;">
                                        <i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">{{ edit_mode ? 'Create' : 'Edit'
                                }}
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="ms-auto">
                        <!-- <Address></Address> -->
                    </div>
                </div>

                <div class="card">
                    <form @submit.prevent="submit()">
                        <div class="card-body">
                            <div class="invoice overflow-auto">

                                <div class="row">
                                    <h6 class="invoice-heading">INVOICE TO</h6>
                                    <hr>

                                    <div class="col-md-3" v-if="page_type == 'invoice'">
                                        <InputLabel for="" value="Invoice Date" class="mb-1" />
                                        <VueDatePicker v-model="form.invoice_at" :teleport="true"></VueDatePicker>
                                        <InputError :message="form.errors.invoice_at" />
                                    </div>

                                    <div class="col-md-3">
                                        <InputLabel for="" value="Company Account" class="mb-1" />
                                        <select class="form-control" v-model="form.company_id"
                                            @change="fetchAddress('company')">
                                            <template v-for="company in companies" :key="company.id">
                                                <option :value="company.id">{{ company.id }} - {{
                                                    company.name }}
                                                </option>
                                            </template>
                                        </select>
                                        <InputError :message="form.errors.company_id" />
                                    </div>

                                    <div class="col-md-2">
                                        <InputLabel for="" value="MAWB No" class="mb-1" />
                                        <input type="text" class="form-control" v-model="form.mawb_no">
                                        <InputError :message="form.errors.mawb_no" />
                                    </div>

                                    <div class="col-md-2">
                                        <InputLabel for="" value="Carrier" class="mb-1" />
                                        <input type="text" class="form-control" v-model="form.carrier">
                                        <InputError :message="form.errors.carrier" />
                                    </div>

                                    <div class="col-md-2" v-if="page_type == 'invoice'">
                                        <InputLabel for="" value="Invoice Status" class="mb-1" />
                                        <select class="form-control" v-model="form.status_id">
                                            <option :value="1">Pending</option>
                                            <option :value="2">Approved</option>
                                            <option :value="3">Rejected</option>
                                        </select>
                                        <InputError :message="form.errors.status_id" />
                                    </div>

                                </div>

                                <div class="my-3"></div>

                                <div class="row">

                                    <div class="col-md-4">
                                        <h6 class="invoice-heading">SHIPPER</h6>
                                        <hr>
                                        <div class="row g-2">
                                            <div class="col-md-12">
                                                <label for="input13" class="form-label">Account
                                                    Number
                                                    <UserCreateEdit :roles="roles" :selected_role="3" ref="create_edit_ref">
                                                    </UserCreateEdit>

                                                    <PrimaryButton @click="edit(selected_shipper)" type="button">Edit
                                                        <i class="bx bx-edit ms-1"></i>
                                                    </PrimaryButton>
                                                </label>
                                                <select class="form-control" v-model="form.shipper_id"
                                                    @change="fetchShipper(form.shipper_id)">
                                                    <template v-for="shipper in shippers" :key="shipper.id">
                                                        <option :value="shipper.id">{{ shipper.id }} - {{
                                                            shipper.name }}
                                                        </option>
                                                    </template>
                                                </select>
                                                <InputError :message="form.errors.shipper_id" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="invoice-heading">CONSIGNEE</h6>
                                        <hr>
                                        <div class="row g-2">
                                            <div class="col-md-12">
                                                <label for="input13" class="form-label">Account
                                                    Number <UserCreateEdit :roles="roles" :selected_role="4"
                                                        ref="create_edit_ref">
                                                    </UserCreateEdit>

                                                    <PrimaryButton @click="edit(selected_consignee)" type="button">Edit
                                                        <i class="bx bx-edit ms-1"></i>
                                                    </PrimaryButton>
                                                </label>
                                                <select class="form-control" v-model="form.consignee_id"
                                                    @change="fetchConsignee(form.consignee_id)">
                                                    <template v-for="consignee in consignees" :key="consignee.id">
                                                        <option :value="consignee.id">{{ consignee.id }} - {{
                                                            consignee.name }}
                                                        </option>
                                                    </template>
                                                </select>
                                                <InputError :message="form.errors.consignee_id" />
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="my-3"></div>

                                <div class="row g-2">
                                    <h6 class="invoice-heading">SHIPMENT DETAIL</h6>
                                    <hr>

                                    <div class="col-md-3">
                                        <InputLabel for="" value="Departure Date" class="mb-1" />
                                        <VueDatePicker v-model="form.departure_at" :teleport="true" :is-24="false">
                                        </VueDatePicker>
                                        <InputError :message="form.errors.departure_at" />
                                    </div>

                                    <div class="col-md-3">
                                        <InputLabel for="" value="Landing Date" class="mb-1" />
                                        <VueDatePicker v-model="form.landing_at" :teleport="true" :is-24="false">
                                        </VueDatePicker>
                                        <InputError :message="form.errors.landing_at" />
                                    </div>

                                    <div class="col-md-3">
                                        <InputLabel for="" value="Port of Departure" class="mb-1" />
                                        <input type="text" class="form-control" v-model="form.sender">
                                        <InputError :message="form.errors.sender" />
                                    </div>
                                    <div class="col-md-3">
                                        <InputLabel for="" value="Port of Landing" class="mb-1" />
                                        <input type="text" class="form-control" v-model="form.destination">
                                        <InputError :message="form.errors.destination" />
                                    </div>


                                    <div class="col-md-6">
                                        <InputLabel for="" value="Commodity" class="mb-1" />
                                        <input type="text" class="form-control" v-model="form.commodity">
                                        <InputError :message="form.errors.commodity" />
                                    </div>

                                    <div class="col-md-1">
                                        <InputLabel for="" value="Quantity" class="mb-1" />
                                        <input type="text" class="form-control" v-model="form.quantity">
                                        <InputError :message="form.errors.quantity" />
                                    </div>

                                    <div class="col-md-1">
                                        <InputLabel for="" value="Weight" class="mb-1" />
                                        <input type="text" class="form-control" v-model="form.weight">
                                        <InputError :message="form.errors.weight" />
                                    </div>
                                    <div class="col-md-1">
                                        <InputLabel for="" value="AFC Rate/KG" class="mb-1" />
                                        <input type="text" class="form-control" v-model="form.afc_rate">
                                        <InputError :message="form.errors.afc_rate" />
                                    </div>
                                </div>

                                <template v-if="page_type == 'invoice'">
                                    <div class="my-3"></div>

                                    <h6 class="invoice-heading">PARTICULARS</h6>

                                    <div class="col-md-6">
                                        <InputLabel for="" value="Templates" class="mb-1" />
                                        <select class="form-control" v-model="form.template_id"
                                            @change="changeTemplate(form.template_id)">
                                            <template v-for="template in templates" :key="template.id">
                                                <option :value="template.id">{{template.title }}</option>
                                            </template>
                                        </select>
                                    </div>

                                    <hr>

                                    

                                    <table>
                                        <thead>
                                            <tr>
                                                <th style="width:5%">
                                                    <button type="button" @click="addItem()"
                                                        class="ms-1 text-sucess btn btn-success btn-sm"><i
                                                            class='bx bx-plus'></i>Add
                                                        Item</button>
                                                </th>
                                                <th class="text-left" colspan="3" style="width:45%">PARTICULARS</th>
                                                <th class="text-left" style="width:15%">UNIT PRICE</th>
                                                <th class="text-left" style="width:10%">QUANTITY</th>
                                                <th class="text-left" style="width:15%">TOTAL</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <template v-for="(item, index) in form.items" :key="item.id">
                                                <tr>
                                                    <td class="no" style="width:5%">
                                                        <span>
                                                            Item #{{ index }}

                                                            <button type="button" @click="removeItem(index)"
                                                                class="ms-1 text-danger"><i
                                                                    class='bx bxs-trash'></i></button>
                                                        </span>

                                                    </td>
                                                    <td class="text-left" colspan="3" style="width:45%">
                                                        <input type="text" class="form-control" v-model="item.particular">
                                                    </td>
                                                    <td class="text-left" style="width:15%">
                                                        <input type="number" class="form-control" v-model="item.amount"
                                                            @keyup="getLineTotal(index)">
                                                    </td>
                                                    <td class="text-left" style="width:10%">
                                                        <input type="number" class="form-control" v-model="item.qty"
                                                            @keyup="getLineTotal(index)">
                                                    </td>
                                                    <td class="total" style="width:15%">PKR {{ format_number(item.total)
                                                    }}</td>
                                                </tr>
                                            </template>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4"></td>
                                                <td colspan="2">SUBTOTAL</td>
                                                <td>PKR {{ format_number(form.subtotal) }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"></td>
                                                <td colspan="2">GRAND TOTAL</td>
                                                <td>PKR {{ format_number(form.total) }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </template>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="flex items-center gap-2 mt-2">
                                <PrimaryButton :disabled="form.processing">
                                    {{ edit_mode ? "Update" : "Save" }}
                                </PrimaryButton>

                                <template v-if="page_type == 'shipment'">
                                    <Link :href="route('shipment.index')">
                                    <DangerButton :disabled="form.processing">
                                        Cancel
                                    </DangerButton>
                                    </Link>
                                </template>

                                <template v-if="page_type == 'invoice'">
                                    <Link :href="route('invoice.index')">
                                    <DangerButton :disabled="form.processing">
                                        Cancel
                                    </DangerButton>
                                    </Link>
                                </template>

                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
.invoice table .no {
    color: black;
    font-size: 17px;
    background: #eee;
}

.invoice table td,
.invoice table th {
    padding: 10px;
    background: #eee;
    border-bottom: 1px solid #fff;
}

input[type="number"]:disabled {
    opacity: 0.5;
    background-color: #eee;
}

input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
    display: none;
    -webkit-appearance: none;
    margin: 0;
}

input:disabled {
    cursor: not-allowed;
}

.invoice-heading {
    font-size: 14px
}
</style>
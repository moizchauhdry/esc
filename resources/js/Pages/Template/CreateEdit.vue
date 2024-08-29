<script setup>
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import { ref, watch, onMounted } from "vue";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import SuccessButton from "@/Components/SuccessButton.vue";
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    // roles: Object,
});

const modal = ref(false);
const edit_mode = ref(false);

const form = useForm({
    template_id: "",
    title: "",
    items: [],
});

const create = () => {
    modal.value = true;
    edit_mode.value = false;
};

const submit = () => {
    form.post(route("template.store"), {
        preserveScroll: true,
        onSuccess: (response) => {
            closeModal();
        },
        onError: (errors) => {
            console.log(errors)
        },
        onFinish: () => { },
    });
};


const edit = (template) => {
    if (template) {
        modal.value = true;
        edit_mode.value = true;
        form.template_id = template.id
        form.title = template.title

        axios.get(`/templates/fetch/particulars/${template.id}`)
            .then(({ data }) => {
                form.items = data.particulars
            });
    }
};

const update = () => {
    form.post(route("template.update"), {
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
    modal.value = false;
    form.reset();
};


const addItem = () => {
    form.items.push({
        particular: "",
        amount: "",
        qty: 1,
        total: 0,
    });
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

const format_number = (number) => {
    return new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(number);
};

defineExpose({ edit: (template) => edit(template) });

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
});
</script>

<template>
    <PrimaryButton @click="create" type="button">Add Template</PrimaryButton>

    <Modal :show="modal" @close="closeModal">
        <form @submit.prevent="edit_mode ? update() : submit()">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">Template {{ edit_mode ? 'Edit' : 'Create' }}</h2>
                <hr>
                <div class="mt-6">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="input13" class="form-label">Template Title</label>
                            <div class="position-relative input-icon">
                                <input type="text" class="form-control" id="input13" placeholder="Title"
                                    v-model="form.title">
                                <span class="position-absolute top-50 translate-middle-y"><i class='bx bx-user'></i></span>
                            </div>
                            <InputError :message="form.errors.title" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="my-3"></div>

                        <h6 class="invoice-heading"> PARTICULARS
                            <SuccessButton type="button" class="float-right" @click="addItem()">
                                <i class='bx bx-plus'></i>Add Item
                            </SuccessButton>
                        </h6>
                        <hr>

                        <table v-if="form.items.length > 0">
                            <thead>
                                <tr>
                                    <th style="width:12%">SR.NO.</th>
                                    <th class="text-left" colspan="3" style="width:45%">PARTICULARS</th>
                                    <th class="text-left" style="width:15%">PRICE</th>
                                    <th class="text-left" style="width:10%">QTY</th>
                                    <th class="text-left" style="width:15%">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>

                                <template v-for="(item, index) in form.items" :key="item.id">
                                    <tr>
                                        <td class="no" style="width:5%">
                                            <span>
                                                Item #{{ index }}

                                                <button type="button" @click="removeItem(index)" class="ms-1 text-danger"><i
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
                                        <th class="total" style="width:1%">PKR {{ format_number(item.total)
                                        }}</th>
                                    </tr>
                                </template>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4"></th>
                                    <th colspan="2">TOTAL</th>
                                    <th>PKR {{ format_number(form.total) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>
                    <SuccessButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        {{ edit_mode ? 'Save & Update' : 'Save & Submit' }}
                    </SuccessButton>
                </div>
            </div>
        </form>
    </Modal>
</template>
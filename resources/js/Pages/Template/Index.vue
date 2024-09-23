<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import CreateEdit from "./CreateEdit.vue";
import Paginate from "@/Components/Paginate.vue";
import SuccessButton from "@/Components/SuccessButton.vue";
import ActionButton from "@/Components/ActionButton.vue";
import DangerButton from "@/Components/DangerButton.vue";

defineProps({
    templates: Array,
});

const create_edit_ref = ref(null);

const edit = (template) => {
    create_edit_ref.value.edit(template)
};

const form = useForm({
    search_key: 1,
    search_value: ""
});

const search = () => {
    form.post(route("template.index"), {
        preserveScroll: true,
        onSuccess: (response) => {
            // 
        },
        onError: (errors) => {
            console.log(errors)
        },
        onFinish: () => { },
    });
};

const resetFilter = () => {
    form.search_key = 2;
    form.search_value = "";
};
</script>


<template>
    <Head title="Templates" />

    <AuthenticatedLayout>
        <!--start page wrapper -->
        <div class="page-wrapper">
            <div class="page-content">
                <!--breadcrumb-->
                <div class="page-breadcrumb d-sm-flex align-items-center mb-3">
                    <div class="breadcrumb-title pe-3">Template Management</div>
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="javascript:;">
                                        <i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Template List</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="ms-auto">
                        <CreateEdit :roles="roles" ref="create_edit_ref"></CreateEdit>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">

                        <form @submit.prevent="search">
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <select v-model="form.search_key" class="form-control" @change="clearSearch">
                                        <option value="1">ID</option>
                                        <option value="2">Title</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <input type="search" v-model="form.search_value" class="form-control"
                                        placeholder="Search">
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
                            <table id="example" class="table table-bordered table-striped" style="width:100%">
                                <thead class="table-dark">
                                    <tr class="text-uppercase">
                                        <th>Sr.No.</th>
                                        <th>Template ID</th>
                                        <th>Title</th>
                                        <th>Updated at</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-for="(template, index) in templates.data">
                                        <tr>
                                            <td>
                                                {{ (templates.current_page - 1) * templates.per_page + index + 1 }}
                                            </td>
                                            <td>00{{ template.id }}</td>
                                            <td>{{ template.title }}</td>
                                            <td>{{ template.updated_at }}</td>
                                            <td>
                                                <ActionButton @click="edit(template)" title="Edit" class="mr-1">
                                                    <i class="bx bx-edit"></i>
                                                </ActionButton>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="float-right">
                            <Paginate :links="templates.links" />
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!--end page wrapper -->
    </AuthenticatedLayout>
</template>
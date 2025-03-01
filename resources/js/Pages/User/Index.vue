<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import CreateEdit from "./CreateEdit.vue";
import Paginate from "@/Components/Paginate.vue";
import SuccessButton from "@/Components/SuccessButton.vue";
import ActionButton from "@/Components/ActionButton.vue";
import ResetPassword from "./ResetPassword.vue";
import DangerButton from "@/Components/DangerButton.vue";

defineProps({
    users: Object,
    roles: Object,
});

const create_edit_ref = ref(null);
const password_ref = ref(null);

const edit = (user) => {
    create_edit_ref.value.edit(user)
};

const resetPasswordFunc = (user) => {
    password_ref.value.resetpasswordfunc(user)
};

const form = useForm({
    search_key: 2,
    search_value: ""
});

const search = () => {
    form.post(route("user.index"), {
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
    <Head title="Users" />

    <AuthenticatedLayout>
        <!--start page wrapper -->
        <div class="page-wrapper">
            <div class="page-content">
                <!--breadcrumb-->
                <div class="page-breadcrumb d-sm-flex align-items-center mb-3">
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
                        <CreateEdit :roles="roles" ref="create_edit_ref"></CreateEdit>
                        <ResetPassword ref="password_ref"></ResetPassword>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">

                        <form @submit.prevent="search">
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <select v-model="form.search_key" class="form-control" @change="clearSearch">
                                        <option value="1">User ID</option>
                                        <option value="2">Name</option>
                                        <option value="3">Email</option>
                                        <option value="4">Role</option>
                                    </select>
                                </div>

                                <template v-if="form.search_key == 1 || form.search_key == 2 || form.search_key == 3">
                                    <div class="col-md-3">
                                        <input type="search" v-model="form.search_value" class="form-control"
                                            placeholder="Search">
                                    </div>
                                </template>

                                <template v-if="form.search_key == 4">
                                    <div class="col-md-3">
                                        <select v-model="form.search_value" class="form-control">
                                        <template v-for="role in roles">
                                            <option :value="role.id">{{ role.name }}</option>
                                        </template>
                                    </select>
                                    </div>
                                </template>

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
                                        <th>User ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Register Date</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-for="(user, index) in users.data">
                                        <tr>
                                            <td>
                                                {{ (users.current_page - 1) * users.per_page + index + 1 }}
                                            </td>
                                            <td>00{{ user.id }}</td>
                                            <td>{{ user.name }}</td>
                                            <td>
                                                <template v-if="!([3, 4].includes(user.role_id))">
                                                    {{ user.email }}
                                                </template>
                                            </td>
                                            <td>{{ user.role }}</td>
                                            <td>{{ user.created_at }}</td>
                                            <td>
                                                <ActionButton @click="edit(user)" title="Edit" class="mr-1">
                                                    <i class="bx bx-edit"></i>
                                                </ActionButton>

                                                <ActionButton @click="resetPasswordFunc(user)" title="Reset Password"
                                                    clas="btn btn-primary"><i class="bx bx-box"></i></ActionButton>

                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="float-right">
                            <Paginate :links="users.links" />
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!--end page wrapper -->
    </AuthenticatedLayout>
</template>
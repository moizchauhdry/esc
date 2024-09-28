<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import { computed, onMounted, onUnmounted, watch } from 'vue';

const permission = usePage().props.can;

const props = defineProps({
    closeable: {
        type: Boolean,
        default: true,
    },
});

const emit = defineEmits(['toggle']);

const toggle = () => {
    if (props.closeable) {
        emit('toggle');
    }
};

const isSubmenuVisible = ref({
    dashboard: false,
});

const toggleList = (menu) => {
    isSubmenuVisible.value[menu] = !isSubmenuVisible.value[menu];
};

watch(
    () => {
        if (route().current('dashboard')) {
            isSubmenuVisible.value.dashboard = true;
        }
        else if (route().current('user.index') || route().current('role.index')) {
            isSubmenuVisible.value.user = true;
        }
        else if (route().current('shipment.index') || route().current('invoice.index')) {
            isSubmenuVisible.value.shipment = true;
        }
        else if (route().current('ledger.index') || route().current('ledger.company')) {
            isSubmenuVisible.value.ledger = true;
        }
        else if (route().current('template.index')) {
            isSubmenuVisible.value.template = true;
        }
        else if (route().current('report.sale-report')) {
            isSubmenuVisible.value.report = true;
        }
    }
);

</script>

<template>
    <div class="sidebar-wrapper" data-simplebar="true">
        <div class="sidebar-header">
            <div>
                <img src="../../../images/logo-icon.png" class="logo-icon" alt="logo icon">
            </div>
            <div>
                <h4 class="logo-text">ESC Portal</h4>
            </div>
            <div class="toggle-icon ms-auto" @click="toggle"><i class='bx bx-arrow-back'></i>
            </div>
        </div>
        <!--navigation-->
        <ul class="metismenu" id="menu">
            <li :class="{ 'mm-active': route().current('dashboard') }" v-if="permission.dashboard">
                <a href="javascript:;" class="has-arrow" @click="toggleList('dashboard')">
                    <div class="parent-icon"><i class='bx bx-home-alt'></i>
                    </div>
                    <div class="menu-title">Dashboard</div>
                </a>
                <ul :class="{ 'hidden': !isSubmenuVisible.dashboard }">
                    <li :class="{ 'mm-active': route().current('dashboard') }" v-if="permission.dashboard">
                        <Link :href="route('dashboard')"><i class='bx bx-radio-circle'></i>Analytics</Link>
                    </li>
                </ul>
            </li>

            <!-- <li class="menu-label">Application</li> -->

            <li v-if="permission.user_list || permission.role_list"
                :class="{ 'mm-active': route().current('user.index') || route().current('role.index') }">
                <a href="javascript:;" class="has-arrow" @click="toggleList('user')">
                    <div class="parent-icon"><i class="bx bx-user"></i>
                    </div>
                    <div class="menu-title">Manage Users</div>
                </a>
                <ul :class="{ 'hidden': !isSubmenuVisible.user }">
                    <li v-if="permission.user_list" :class="{ 'mm-active': route().current('user.index') }">
                        <Link :href="route('user.index')"><i class='bx bx-radio-circle'></i>List Users</Link>
                    </li>
                    <li v-if="permission.role_list" :class="{ 'mm-active': route().current('role.index') }">
                        <Link :href="route('role.index')"><i class='bx bx-radio-circle'></i>Role & Permissions</Link>
                    </li>
                </ul>
            </li>

            <li v-if="permission.shipment_list || permission.invoice_list"
                :class="{ 'mm-active': route().current('shipment.index') || route().current('invoice.index') }">
                <a href="javascript:;" class="has-arrow" @click="toggleList('shipment')">
                    <div class="parent-icon"><i class="bx bx-box"></i>
                    </div>
                    <div class="menu-title">Manage Shipments</div>
                </a>
                <ul :class="{ 'hidden': !isSubmenuVisible.shipment }">
                    <li v-if="permission.shipment_list" :class="{ 'mm-active': route().current('shipment.index') }">
                        <Link :href="route('shipment.index')"><i class='bx bx-radio-circle'></i>Pre-Shipments</Link>
                    </li>
                    <li v-if="permission.invoice_list" :class="{ 'mm-active': route().current('invoice.index') }">
                        <Link :href="route('invoice.index')"><i class='bx bx-radio-circle'></i>List Invoices</Link>
                    </li>
                </ul>
            </li>

            <li v-if="permission.ledger_list || permission.ledger_company"
                :class="{ 'mm-active': route().current('ledger.index') || route().current('ledger.company') }">
                <a href="javascript:;" class="has-arrow" @click="toggleList('ledger')">
                    <div class="parent-icon"><i class="bx bx-printer"></i>
                    </div>
                    <div class="menu-title">Manage Ledgers</div>
                </a>
                <ul :class="{ 'hidden': !isSubmenuVisible.ledger }">
                    <li v-if="permission.ledger_list" :class="{ 'mm-active': route().current('ledger.index') }">
                        <Link :href="route('ledger.index')"><i class='bx bx-radio-circle'></i>General Ledger</Link>
                    </li>
                    <li v-if="permission.ledger_company" :class="{ 'mm-active': route().current('ledger.company') }">
                        <Link :href="route('ledger.company')"><i class='bx bx-radio-circle'></i>Company Ledger</Link>
                    </li>
                </ul>
            </li>

            <li v-if="permission.template_list" :class="{ 'mm-active': route().current('template.index') }">
                <a href="javascript:;" class="has-arrow" @click="toggleList('template')">
                    <div class="parent-icon"><i class="bx bx-box"></i>
                    </div>
                    <div class="menu-title">Manage Templates</div>
                </a>
                <ul :class="{ 'hidden': !isSubmenuVisible.template }">
                    <li v-if="permission.template_list" :class="{ 'mm-active': route().current('template.index') }">
                        <Link :href="route('template.index')"><i class='bx bx-radio-circle'></i>Template List</Link>
                    </li>
                </ul>
            </li>

            <li v-if="permission.report" :class="{ 'mm-active': route().current('report.sale.index') }">
                <a href="javascript:;" class="has-arrow" @click="toggleList('reports')">
                    <div class="parent-icon"><i class="bx bx-box"></i>
                    </div>
                    <div class="menu-title">Manage Reports</div>
                </a>
                <ul :class="{ 'hidden': !isSubmenuVisible.reports }">
                    <li v-if="permission.report_sale" :class="{ 'mm-active': route().current('report.sale.index') }">
                        <Link :href="route('report.sale.index')"><i class='bx bx-radio-circle'></i>Sale Report</Link>
                    </li>
                </ul>
            </li>

        </ul>
        <!--end navigation-->
    </div>
</template>

<style>
.sidebar-wrapper {
    overflow-y: hidden;
    transition: overflow-y 0.3s ease;
}

.sidebar-wrapper:hover {
    overflow-y: auto;
}

/* width */
::-webkit-scrollbar {
    width: 4px;
    height: 4px;
}

/* Track */
::-webkit-scrollbar-track {
    background: transparent
}

/* Handle */
::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 10px;
    /* Add radius */

}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
    background: rgb(204, 201, 201);
}
</style>
<script setup>
import { Link, usePage } from "@inertiajs/vue3";
const permission = usePage().props.can;
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
            <div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
            </div>
        </div>
        <!--navigation-->
        <ul class="metismenu" id="menu">
            <li v-if="permission.dashboard">
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-home-alt'></i>
                    </div>
                    <div class="menu-title">Dashboard</div>
                </a>
                <ul>
                    <li v-if="permission.dashboard">
                        <Link :href="route('dashboard')"><i class='bx bx-radio-circle'></i>Analytics</Link>
                    </li>
                </ul>
            </li>
            <!-- <li class="menu-label">Application</li> -->
            <li v-if="permission.user_list || permission.role_list">
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-category"></i>
                    </div>
                    <div class="menu-title">Manage Users</div>
                </a>
                <ul>
                    <li v-if="permission.user_list">
                        <Link :href="route('user.index')"><i class='bx bx-radio-circle'></i>List Users</Link>
                    </li>
                    <li v-if="permission.role_list">
                        <Link :href="route('role.index')"><i class='bx bx-radio-circle'></i>Role & Permissions</Link>
                    </li>
                </ul>
            </li>
            <li v-if="permission.shipment_list || permission.invoice_list || ledger_list">
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-printer"></i>
                    </div>
                    <div class="menu-title">Manage Shipments</div>
                </a>
                <ul>
                    <li v-if="permission.shipment_list">
                        <Link :href="route('shipment.index')"><i class='bx bx-radio-circle'></i>Shipment List</Link>
                    </li>
                    <li v-if="permission.invoice_list">
                        <Link :href="route('invoice.index')"><i class='bx bx-radio-circle'></i>Invoice List</Link>
                    </li>
                    <li v-if="permission.ledger_list">
                        <Link :href="route('ledger.index')"><i class='bx bx-radio-circle'></i>Ledger List</Link>
                    </li>
                </ul>
            </li>

        </ul>
        <!--end navigation-->
    </div>
</template>
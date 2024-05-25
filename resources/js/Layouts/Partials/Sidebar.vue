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
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-home-alt'></i>
                    </div>
                    <div class="menu-title">Dashboard</div>
                </a>
                <ul>
                    <li>
                        <Link :href="route('dashboard')"><i class='bx bx-radio-circle'></i>Analytics</Link>
                    </li>
                </ul>
            </li>
            <!-- <li class="menu-label">Application</li> -->
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-category"></i>
                    </div>
                    <div class="menu-title">Manage Users</div>
                </a>
                <ul>
                    <li>
                        <Link :href="route('user.index')"><i class='bx bx-radio-circle'></i>List Users</Link>
                    </li>
                    <li>
                        <Link :href="route('role.index')"><i class='bx bx-radio-circle'></i>Role & Permissions</Link>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-printer"></i>
                    </div>
                    <div class="menu-title">Manage Shipments</div>
                </a>
                <ul>
                    <li>
                        <Link :href="route('shipment.index')"><i class='bx bx-radio-circle'></i>Shipment List</Link>
                    </li>
                    <!-- v-if="permission.invoice_list" -->
                    <li >
                        <Link :href="route('invoice.index')"><i class='bx bx-radio-circle'></i>Invoice List</Link>
                    </li>
                    <li>
                        <Link :href="route('ledger.index')"><i class='bx bx-radio-circle'></i>General Ledger</Link>
                    </li>
                </ul>
            </li>

        </ul>
        <!--end navigation-->
    </div>
</template>
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, usePage } from "@inertiajs/vue3";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Chart from 'chart.js/auto';
import { getRelativePosition } from 'chart.js/helpers';
import { onMounted } from "vue";

const permission = usePage().props.can;
const role = usePage().props.auth.user.roles[0];

defineProps({
    data: Array,
});

const format_number = (number) => {
    return new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(number);
};


onMounted(() => {
    const ctx1 = document.getElementById('chart-1');
    const ctx2 = document.getElementById('chart-2');
    const ctx3 = document.getElementById('chart-3');
    const ctx4 = document.getElementById('chart-4');
    const ctx5 = document.getElementById('chart-5');

    // const data = [
    //     { year: 2010, count: 10 },
    //     { year: 2011, count: 20 },
    //     { year: 2012, count: 15 },
    //     { year: 2013, count: 25 },
    //     { year: 2014, count: 22 },
    //     { year: 2015, count: 30 },
    //     { year: 2016, count: 28 },
    // ];

    const DATA_COUNT = 7;
    const NUMBER_CFG = { count: DATA_COUNT, min: -100, max: 100 };
    const labels =  ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

    const data = {
        labels: labels,
        datasets: [
            {
                label: 'Dataset 1',
                data: [0, 10, 5, 2, 20, 30, 45, 10, 20, 30, 40, 50],
                stack: 'Stack 0',
            },
            {
                label: 'Dataset 2',
                data: [0, 10, 5, 2, 20, 30, 45, 10, 20, 30, 40, 50],
                stack: 'Stack 1',
            },
        ]
    };

    const chart1 = new Chart(ctx1, {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            datasets: [{
                label: 'Revenue',
                // backgroundColor: 'rgb(255, 99, 132)',
                // borderColor: 'rgb(255, 99, 132)',
                data: [0, 10, 5, 2, 20, 30, 45, 10, 20, 30, 40, 50]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
        }
    });

    const chart2 = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: ['January', 'February',],
            datasets: [{
                label: 'My First dataset',
                // backgroundColor: 'rgb(255, 99, 132)',
                // borderColor: 'rgb(255, 99, 132)',
                data: [0, 10, 5, 2, 20, 30, 45]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            onClick: (e) => {
                const canvasPosition = getRelativePosition(e, chart);

                // Substitute the appropriate scale IDs
                const dataX = chart.scales.x.getValueForPixel(canvasPosition.x);
                const dataY = chart.scales.y.getValueForPixel(canvasPosition.y);
            },
        }
    });

    const chart3 = new Chart(ctx3, {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
        }
    });

    const char4 = new Chart(ctx4, {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March',],
            datasets: [{
                label: 'My First dataset',
                // backgroundColor: 'rgb(255, 99, 132)',
                // borderColor: 'rgb(255, 99, 132)',
                data: [0, 10, 5, 2, 20, 30, 45]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
        }
    });

    const char5 = new Chart(ctx5, {
        type: 'doughnut',
        data: {
            labels: ['January', 'February'],
            datasets: [{
                label: 'My First dataset',
                // backgroundColor: 'rgb(255, 99, 132)',
                // borderColor: 'rgb(255, 99, 132)',
                data: [0, 10, 5, 2, 20, 30, 45]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,   // 
        }
    });

});
</script>

<style>
    .page_loader_page{
        background: rgba(255, 255, 255, 0.8);
        /* background: black; */
        height: 94vh;
        width: 100%;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1;
    }
    .page_loader {
        width: 120px;
        aspect-ratio: 1;
        border-radius: 50%;
        background: 
            radial-gradient(farthest-side,#ffa516 94%,#0000) top/14px 14px no-repeat,
            conic-gradient(#0000 30%,#ffa516);
        -webkit-mask: radial-gradient(farthest-side,#0000 calc(100% - 14px),#000 0);
        animation: l13 1s infinite linear;
    }
    @keyframes l13{ 
    100%{transform: rotate(1turn)}
    }

    @media screen and (max-width: 770px) {
        .page_loader {
            width: 80px;
        }
    }

</style>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        
        
        
        <!--start page wrapper -->
        <div class="page-wrapper">

                                <!-- --------- Loader ---------- !-->
                        <div class="page_loader_page">
                            <div class="page_loader"></div>
                        </div>

            <div class="page-content">
                <template v-if="permission.analytics">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xxl-4">
                        <div class="col">
                            <div class="card radius-10">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="mb-0 text-secondary">Total Shipments</p>
                                            <h4 class="my-1">{{ data.shipments }}</h4>
                                            <!-- <p class="mb-0 font-13 text-danger">
                                            <i class="bx bxs-down-arrow align-middle"></i>2.6% from last week
                                        </p> -->
                                        </div>
                                        <div class="widgets-icons bg-light-danger text-danger ms-auto"><i
                                                class="bx bxs-box"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card radius-10">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="mb-0 text-secondary">Revenue</p>
                                            <h4 class="my-1">PKR {{ format_number(data.revenue) }}</h4>
                                            <!-- <p class="mb-0 font-13 text-success">
                                            <i class="bx bxs-up-arrow align-middle"></i>$34
                                            from last week
                                        </p> -->
                                        </div>
                                        <div class="widgets-icons bg-light-success text-success ms-auto"><i
                                                class='bx bx-key'></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col" v-if="role.id != 2">
                            <div class="card radius-10">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="mb-0 text-secondary">Total Clients</p>
                                            <h4 class="my-1">{{ data.companies }}</h4>
                                            <!-- <p class="mb-0 font-13 text-success">
                                            <i class="bx bxs-up-arrow align-middle"></i>3.2% from last week
                                        </p> -->
                                        </div>
                                        <div class="widgets-icons bg-light-info text-info ms-auto"><i
                                                class="bx bxs-user-check"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col" v-if="role.id != 2">
                            <div class="card radius-10">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="mb-0 text-secondary">Total Users</p>
                                            <h4 class="my-1">{{ data.users }}</h4>
                                            <!-- <p class="mb-0 font-13 text-danger">
                                            <i class="bx bxs-down-arrow align-middle"></i>12.2% from last week
                                        </p> -->
                                        </div>
                                        <div class="widgets-icons bg-light-warning text-warning ms-auto"><i
                                                class="bx bx-user"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </template>

                <template v-else>
                    <div class="text-center flex flex-col items-center justify-center">
                        <ApplicationLogo class="h-20 fill-current text-gray-500" /> <br>

                        <h1 class="font-bold text-2xl">Account ID: {{ $page.props.auth.user.id }}</h1>
                        <h5 class="mb-2 text-3xl font-bold text-gray-900">Welcome, {{ $page.props.auth.user.name }}</h5>
                        <h1 class="font-bold text-2xl">
                            <span>{{ $page.props.auth.user.email }}</span>
                        </h1>
                        <br>
                    </div>
                </template>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card radius-10">
                            <div class="card-body">
                                <div style="height: 300px;width: 100%;">
                                    <canvas id="chart-1"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card radius-10">
                            <div class="card-body">
                                <div style="height: 300px;width: 100%;">
                                    <canvas id="chart-3"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card radius-10">
                            <div class="card-body">
                                <div style="height: 300px;">
                                    <canvas id="chart-2"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card radius-10">
                            <div class="card-body">
                                <div style="height: 300px;">
                                    <canvas id="chart-4"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card radius-10">
                            <div class="card-body">
                                <div style="height: 300px;">
                                    <canvas id="chart-5"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div class="row">
                    <div class="col-12 col-lg-8 d-flex">
                        <div class="card radius-10 w-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div>
                                        <h6 class="mb-0">Sales Overview</h6>
                                    </div>
                                    <div class="dropdown ms-auto">
                                        <a class="dropdown-toggle dropdown-toggle-nocaret" href="#"
                                            data-bs-toggle="dropdown"><i
                                                class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="javascript:;">Action</a>
                                            </li>
                                            <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="chart-container-9">
                                    <canvas id="chart1"></canvas>
                                </div>
                            </div>
                            <div
                                class="row row-cols-1 row-cols-md-3 row-cols-xl-3 g-0 row-group text-center border-top">
                                <div class="col">
                                    <div class="p-3">
                                        <h5 class="mb-0">24.15M</h5>
                                        <small class="mb-0">Overall Visitor <span> <i
                                                    class="bx bx-up-arrow-alt align-middle"></i> 2.43%</span></small>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="p-3">
                                        <h5 class="mb-0">12:38</h5>
                                        <small class="mb-0">Visitor Duration <span> <i
                                                    class="bx bx-up-arrow-alt align-middle"></i> 12.65%</span></small>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="p-3">
                                        <h5 class="mb-0">639.82</h5>
                                        <small class="mb-0">Pages/Visit <span> <i
                                                    class="bx bx-up-arrow-alt align-middle"></i> 5.62%</span></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 d-flex">
                        <div class="card radius-10 w-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h6 class="mb-0">Trending Products</h6>
                                    </div>
                                    <div class="dropdown ms-auto">
                                        <a class="dropdown-toggle dropdown-toggle-nocaret" href="#"
                                            data-bs-toggle="dropdown"><i
                                                class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="javascript:;">Action</a>
                                            </li>
                                            <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="chart-container-13 mt-3">
                                    <canvas id="chart2"></canvas>
                                </div>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li
                                    class="list-group-item d-flex bg-transparent justify-content-between align-items-center border-top">
                                    T-Shirts <span class="badge bg-danger rounded-pill">10</span>
                                </li>
                                <li
                                    class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
                                    Shoes <span class="badge bg-primary rounded-pill">65</span>
                                </li>
                                <li
                                    class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
                                    Lingerie <span class="badge bg-warning text-dark rounded-pill">14</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div> -->

                <!-- <div class="row">
                    <div class="col-12 col-lg-4 d-flex">
                        <div class="card radius-10 overflow-hidden w-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div>
                                        <h6 class="mb-0">Last 30 Days</h6>
                                    </div>
                                    <div class="dropdown ms-auto">
                                        <a class="dropdown-toggle dropdown-toggle-nocaret" href="#"
                                            data-bs-toggle="dropdown"><i
                                                class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="javascript:;">Action</a>
                                            </li>
                                            <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="chart-container-4">
                                    <canvas id="chart3"></canvas>
                                </div>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item border-top">
                                    <div class="d-flex align-items-center justify-content-between p-2">
                                        <div class="">
                                            <h4 class="mb-0">58.6K</h4>
                                            <p class="mb-0">Page Views</p>
                                        </div>
                                        <div class="">
                                            <div id="chart4"></div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center justify-content-between p-2">
                                        <div class="">
                                            <p class="mb-0">Total Clicks</p>
                                            <h4 class="mb-0">48.2K</h4>
                                        </div>
                                        <div class="">
                                            <div id="chart5"></div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center justify-content-between p-2">
                                        <div class="">
                                            <p class="mb-0">Total Comments</p>
                                            <h4 class="mb-0">8,456</h4>
                                        </div>
                                        <div class="">
                                            <div id="chart6"></div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center justify-content-between p-2">
                                        <div class="">
                                            <p class="mb-0">Total Returns</p>
                                            <h4 class="mb-0">298</h4>
                                        </div>
                                        <div class="">
                                            <div id="chart7"></div>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 d-flex">
                        <div class="card radius-10 w-100">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-12 col-lg-6">
                                        <div class="card radius-10 shadow-none border mb-0">
                                            <div class="card-body">
                                                <div class="text-center">
                                                    <div class="w_chart chart8 mb-1" data-percent="78">
                                                        <span class="w_percent"></span>
                                                    </div>
                                                    <p class="mb-0 text-secondary">New Visits</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="card radius-10 shadow-none border mb-0">
                                            <div class="card-body">
                                                <div class="text-center">
                                                    <div class="w_chart chart9 mb-1" data-percent="65">
                                                        <span class="w_percent"></span>
                                                    </div>
                                                    <p class="mb-0 text-secondary">Bounce Rate</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="card radius-10 shadow-none border mb-0">
                                            <div class="card-body">
                                                <div class="text-center">
                                                    <div class="w_chart chart10 mb-1" data-percent="75">
                                                        <span class="w_percent"></span>
                                                    </div>
                                                    <p class="mb-0 text-secondary">Server Load</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="card radius-10 shadow-none border mb-0">
                                            <div class="card-body">
                                                <div class="text-center">
                                                    <div class="w_chart chart11 mb-1" data-percent="55">
                                                        <span class="w_percent"></span>
                                                    </div>
                                                    <p class="mb-0 text-secondary">Used RAM</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="card radius-10 shadow-none border mb-0">
                                            <div class="card-body">
                                                <div class="text-center">
                                                    <div class="w_chart chart12 mb-1" data-percent="68">
                                                        <span class="w_percent"></span>
                                                    </div>
                                                    <p class="mb-0 text-secondary">Web Traffic</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="card radius-10 shadow-none border mb-0">
                                            <div class="card-body">
                                                <div class="text-center">
                                                    <div class="w_chart chart13 mb-1" data-percent="85">
                                                        <span class="w_percent"></span>
                                                    </div>
                                                    <p class="mb-0 text-secondary">Page Views</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 d-flex">
                        <div class="card radius-10 w-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div>
                                        <h6 class="mb-0">Realtime Visitors</h6>
                                    </div>
                                    <div class="dropdown ms-auto">
                                        <a class="dropdown-toggle dropdown-toggle-nocaret" href="#"
                                            data-bs-toggle="dropdown"><i
                                                class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="javascript:;">Action</a>
                                            </li>
                                            <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div id="geographic-map-2"></div>
                                <div class="table-responsive">
                                    <table class="table align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Country</th>
                                                <th>Visits</th>
                                                <th>Clicks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><i class="flag-icon flag-icon-us me-2"></i>United States</td>
                                                <td>8795</td>
                                                <td>145</td>
                                            </tr>
                                            <tr>
                                                <td><i class="flag-icon flag-icon-ca me-2"></i>Japan</td>
                                                <td>9856</td>
                                                <td>356</td>
                                            </tr>
                                            <tr>
                                                <td><i class="flag-icon flag-icon-au me-2"></i>Australia</td>
                                                <td>5748</td>
                                                <td>524</td>
                                            </tr>
                                            <tr>
                                                <td><i class="flag-icon flag-icon-in me-2"></i>India</td>
                                                <td>8547</td>
                                                <td>127</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> -->


                <!-- <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div>
                                <h6 class="mb-0">Recent Orders</h6>
                            </div>
                            <div class="dropdown ms-auto">
                                <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i
                                        class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="javascript:;">Action</a>
                                    </li>
                                    <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product</th>
                                        <th>Photo</th>
                                        <th>Product ID</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Shipping</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Iphone 5</td>
                                        <td><img src="../../../images/products/01.png" class="product-img-2"
                                                alt="product img">
                                        </td>
                                        <td>#9405822</td>
                                        <td><span class="badge bg-light-success text-success w-100">Paid</span></td>
                                        <td>$1250.00</td>
                                        <td>03 Feb 2020</td>
                                        <td>
                                            <div class="progress" style="height: 4px;">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                    style="width: 100%">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Earphone GL</td>
                                        <td><img src="../../../images/products/02.png" class="product-img-2"
                                                alt="product img">
                                        </td>
                                        <td>#8304620</td>
                                        <td><span class="badge bg-light-warning text-warning w-100">Pending</span></td>
                                        <td>$1500.00</td>
                                        <td>05 Feb 2020</td>
                                        <td>
                                            <div class="progress" style="height: 4px;">
                                                <div class="progress-bar bg-warning" role="progressbar"
                                                    style="width: 60%">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>HD Hand Camera</td>
                                        <td><img src="../../../images/products/03.png" class="product-img-2"
                                                alt="product img">
                                        </td>
                                        <td>#4736890</td>
                                        <td><span class="badge bg-light-danger text-danger w-100">Failed</span></td>
                                        <td>$1400.00</td>
                                        <td>06 Feb 2020</td>
                                        <td>
                                            <div class="progress" style="height: 4px;">
                                                <div class="progress-bar bg-danger" role="progressbar"
                                                    style="width: 70%">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Clasic Shoes</td>
                                        <td><img src="../../../images/products/04.png" class="product-img-2"
                                                alt="product img">
                                        </td>
                                        <td>#8543765</td>
                                        <td><span class="badge bg-light-success text-success w-100">Paid</span></td>
                                        <td>$1200.00</td>
                                        <td>14 Feb 2020</td>
                                        <td>
                                            <div class="progress" style="height: 4px;">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                    style="width: 100%">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sitting Chair</td>
                                        <td><img src="../../../images/products/06.png" class="product-img-2"
                                                alt="product img">
                                        </td>
                                        <td>#9629240</td>
                                        <td><span class="badge bg-light-warning text-warning w-100">Pending</span></td>
                                        <td>$1500.00</td>
                                        <td>18 Feb 2020</td>
                                        <td>
                                            <div class="progress" style="height: 4px;">
                                                <div class="progress-bar bg-warning" role="progressbar"
                                                    style="width: 60%">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Hand Watch</td>
                                        <td><img src="../../../images/products/05.png" class="product-img-2"
                                                alt="product img">
                                        </td>
                                        <td>#8506790</td>
                                        <td><span class="badge bg-light-danger text-danger w-100">Failed</span></td>
                                        <td>$1800.00</td>
                                        <td>21 Feb 2020</td>
                                        <td>
                                            <div class="progress" style="height: 4px;">
                                                <div class="progress-bar bg-danger" role="progressbar"
                                                    style="width: 40%">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
        <!--end page wrapper -->
    </AuthenticatedLayout>

</template>
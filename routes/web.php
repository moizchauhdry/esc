<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CustomerAccountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\WorkOrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::group(['middleware' => ['auth', 'preventBackHistory']], function() {

    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware(['auth', 'verified', 'permission:dashboard'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('user.index')->middleware('permission:user_list');
            Route::get('/create', [UserController::class, 'create'])->name('user.create')->middleware('permission:user_create');
            Route::post('/store', [UserController::class, 'store'])->name('user.store')->middleware('permission:user_create');
            Route::get('/edit', [UserController::class, 'edit'])->name('user.edit')->middleware('permission:user_update');
            Route::post('/update', [UserController::class, 'update'])->name('user.update')->middleware('permission:user_update');
            Route::get('/fetch/shipper/{id}', [UserController::class, 'fetchShipper'])->name('user.fetch-shipper');
            Route::get('/fetch/consignee/{id}', [UserController::class, 'fetchConsignee'])->name('user.fetch-consignee');
        });

        Route::prefix('roles')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('role.index')->middleware('permission:role_list');
            Route::post('/create', [RoleController::class, 'create'])->name('role.create')->middleware('permission:role_create');
            Route::post('/update', [RoleController::class, 'update'])->name('role.update')->middleware('permission:role_update');
        });

        Route::prefix('shipments')->group(function () {
            Route::get('/', [ShipmentController::class, 'index'])->name('shipment.index');
            Route::get('/create', [ShipmentController::class, 'create'])->name('shipment.create')->middleware('permission:shipment_create');
            Route::post('/store', [ShipmentController::class, 'store'])->name('shipment.store')->middleware('permission:shipment_create');
            Route::get('/edit/{id}', [ShipmentController::class, 'edit'])->name('shipment.edit')->middleware('permission:shipment_update');
            Route::post('/update', [ShipmentController::class, 'update'])->name('shipment.update')->middleware('permission:shipment_update');
        });

        Route::prefix('invoices')->group(function () {
            Route::get('/', [InvoiceController::class, 'index'])->name('invoice.index')->middleware('permission:invoice_list');
            Route::get('/create', [InvoiceController::class, 'create'])->name('invoice.create')->middleware('permission:invoice_create');
            Route::post('/store', [InvoiceController::class, 'store'])->name('invoice.store')->middleware('permission:invoice_create');
            Route::get('/edit/{id}', [InvoiceController::class, 'edit'])->name('invoice.edit')->middleware('permission:invoice_update');
            Route::post('/update', [InvoiceController::class, 'update'])->name('invoice.update')->middleware('permission:invoice_update');
            Route::get('/print/{id}', [InvoiceController::class, 'print'])->name('invoice.print')->middleware('permission:invoice_print');
        });

        Route::prefix('ledgers')->group(function () {
            Route::any('/', [LedgerController::class, 'index'])->name('ledger.index');
            Route::post('/payment', [LedgerController::class, 'payment'])->name('ledger.payment');
            Route::get('/print', [LedgerController::class, 'print'])->name('ledger.print');
        });
    });
});

require __DIR__ . '/auth.php';

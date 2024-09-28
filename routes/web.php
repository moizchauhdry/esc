<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CarrierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\TemplateController;
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

Route::group(['middleware' => ['auth', 'preventBackHistory']], function () {

    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware(['auth', 'verified', 'permission:dashboard'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::prefix('users')->group(function () {
            Route::any('/', [UserController::class, 'index'])->name('user.index')->middleware('permission:user_list');
            Route::get('/create', [UserController::class, 'create'])->name('user.create')->middleware('permission:user_create');
            Route::post('/store', [UserController::class, 'store'])->name('user.store')->middleware('permission:user_create');
            Route::get('/edit', [UserController::class, 'edit'])->name('user.edit')->middleware('permission:user_update');
            Route::post('/update', [UserController::class, 'update'])->name('user.update')->middleware('permission:user_update');
            Route::get('/fetch/shipper/{id}', [UserController::class, 'fetchShipper'])->name('user.fetch-shipper');
            Route::get('/fetch/consignee/{id}', [UserController::class, 'fetchConsignee'])->name('user.fetch-consignee');
            Route::post('/reset-password', [UserController::class, 'resetPassword'])->name('user.reset-password');
        });

        Route::prefix('roles')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('role.index')->middleware('permission:role_list');
            Route::post('/create', [RoleController::class, 'create'])->name('role.create')->middleware('permission:role_create');
            Route::post('/update', [RoleController::class, 'update'])->name('role.update')->middleware('permission:role_update');
        });

        Route::prefix('shipments')->group(function () {
            Route::any('/', [ShipmentController::class, 'index'])->name('shipment.index');
            Route::get('/create', [ShipmentController::class, 'create'])->name('shipment.create')->middleware('permission:shipment_create');
            Route::post('/store', [ShipmentController::class, 'store'])->name('shipment.store')->middleware('permission:shipment_create');
            Route::get('/edit/{id}', [ShipmentController::class, 'edit'])->name('shipment.edit')->middleware('permission:shipment_update');
            Route::post('/update', [ShipmentController::class, 'update'])->name('shipment.update')->middleware('permission:shipment_update');
        });

        Route::prefix('invoices')->group(function () {
            Route::any('/', [InvoiceController::class, 'index'])->name('invoice.index')->middleware('permission:invoice_list');
            Route::get('/create', [InvoiceController::class, 'create'])->name('invoice.create')->middleware('permission:invoice_create');
            Route::post('/store', [InvoiceController::class, 'store'])->name('invoice.store')->middleware('permission:invoice_create');
            Route::get('/edit/{id}', [InvoiceController::class, 'edit'])->name('invoice.edit')->middleware('permission:invoice_update');
            Route::post('/update', [InvoiceController::class, 'update'])->name('invoice.update')->middleware('permission:invoice_update');
            Route::get('/print/{id}', [InvoiceController::class, 'print'])->name('invoice.print')->middleware('permission:invoice_print');
            Route::get('/detail/{id}', [InvoiceController::class, 'detail'])->name('invoice.detail');
            Route::post('/upload', [InvoiceController::class, 'upload'])->name('invoice.upload')->middleware('permission:invoice_upload');
            Route::delete('/upload/destroy', [InvoiceController::class, 'uploadDestroy'])->name('invoice.upload.destroy')->middleware('permission:invoice_upload_destroy');
        });

        Route::prefix('ledgers')->group(function () {
            Route::any('/', [LedgerController::class, 'index'])->name('ledger.index');
            Route::post('/payment', [LedgerController::class, 'payment'])->name('ledger.payment')->middleware('permission:ledger_payment');
            Route::get('/print', [LedgerController::class, 'print'])->name('ledger.print');
            Route::get('/company', [LedgerController::class, 'company'])->name('ledger.company')->middleware('permission:ledger_company');
            Route::post('/delete', [LedgerController::class, 'deleteLedger'])->name('ledger.delete')->middleware('permission:ledger_delete');
            Route::post('/update', [LedgerController::class, 'updateLedger'])->name('ledger.update')->middleware('permission:ledger_update');
            Route::post('/balance', [LedgerController::class, 'fetchBalance'])->name('ledger.balance');
            Route::post('/opening-balance', [LedgerController::class, 'openingBalance'])->name('ledger.opening-balance');
            Route::post('/fetch-ledger-invoice', [LedgerController::class, 'fetchLedgerInvoice'])->name('ledger.fetch-ledger-invoice');
        });

        Route::prefix('templates')->group(function () {
            Route::any('/', [TemplateController::class, 'index'])->name('template.index');
            Route::get('/create', [TemplateController::class, 'create'])->name('template.create');
            Route::post('/store', [TemplateController::class, 'store'])->name('template.store');
            Route::get('/edit/{id}', [TemplateController::class, 'edit'])->name('template.edit');
            Route::post('/update', [TemplateController::class, 'update'])->name('template.update');
            Route::get('/fetch/particulars/{id}', [TemplateController::class, 'fetchParticulars'])->name('template.fetch.particulars');
        });

        Route::prefix('carriers')->group(function () {
            Route::get('/create', [CarrierController::class, 'create'])->name('carrier.create');
            Route::post('/store', [CarrierController::class, 'store'])->name('carrier.store');
            Route::get('/edit/{id}', [CarrierController::class, 'edit'])->name('carrier.edit');
            Route::post('/update', [CarrierController::class, 'update'])->name('carrier.update');
            Route::get('/fetch/carrier/{id}', [CarrierController::class, 'fetchCarrier'])->name('carrier.fetch-carrier');
        });

        Route::prefix('reports')->group(function () {
            Route::get('/sale', [ReportController::class, 'saleReport'])->name('report.sale');
            Route::post('/sale/update', [ReportController::class, 'updateSaleReport'])->name('report.sale.update');
        });
    });
});

require __DIR__ . '/auth.php';

<?php

use App\Http\Controllers\AJAXController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\LogisticController;
use App\Http\Controllers\PackagingController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PrincipleController;
use App\Http\Controllers\ProcessPurchaseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\SatuanController;
use App\Models\Quotation;
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

Route::middleware(['sso.login'])->group(function () {

    // AJAX
    Route::prefix('ajax')->group(function (){
        Route::get('/satuan', [AJAXController::class, 'getSatuans']);
        Route::get('/client', [AJAXController::class, 'getClients']);
        Route::get('/client/{id}', [AJAXController::class, 'getClientDetails']);
        Route::get('/product', [AJAXController::class, 'getProducts']);
        Route::get('/packaging', [AJAXController::class, 'getPackagings']);
        Route::post('/product/add', [AJAXController::class, 'storeProduct']);
        Route::get('/product/{id}', [AJAXController::class, 'getProductDetails']);
        Route::get('/packaging/satuan/{satuan_id}', [AJAXController::class, 'getPackagingBySatuan']);
        // Quotation
        Route::get('/quotation', [AJAXController::class, 'getQuotations']);
        Route::get('/quotation/client/{client_id}', [AJAXController::class, 'getQuotationClient']);
        Route::get('/quotation/{id}', [AJAXController::class, 'getQuotationDetails']);
    });

    Route::get('/', [PageController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');

    // Product
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/add', [ProductController::class, 'add'])->name('product.add');
    Route::post('/product/add', [ProductController::class, 'store'])->name('product.store');
    Route::put('/product/{id}/edit', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{id}/destroy', [ProductController::class, 'destroy'])->name('product.destroy');

    // Satuan
    Route::get('/satuan', [SatuanController::class, 'index'])->name('satuan.index');
    Route::post('/satuan/add', [SatuanController::class, 'store'])->name('satuan.store');
    Route::put('/satuan/{id}/edit', [SatuanController::class, 'update'])->name('satuan.update');
    Route::delete('/satuan/{id}/destroy', [SatuanController::class, 'destroy'])->name('satuan.destroy');

    // Principle
    Route::get('/principle', [PrincipleController::class, 'index'])->name('principle.index');
    Route::get('/principle/add', [PrincipleController::class, 'add'])->name('principle.add');
    Route::post('/principle/add', [PrincipleController::class, 'store'])->name('principle.store');
    Route::get('/principle/{id}/edit', [PrincipleController::class, 'edit'])->name('principle.edit');
    Route::put('/principle/{id}/edit', [PrincipleController::class, 'update'])->name('principle.update');
    Route::delete('/principle/{id}/destroy', [PrincipleController::class, 'destroy'])->name('principle.destroy');
    Route::post('/principle/{principle_id}/address/manage', [PrincipleController::class, 'addressManage'])->name('principle.address.manage');
    Route::delete('/principle/{principle_id}/address/{id}/destroy', [PrincipleController::class, 'addressDestroy'])->name('principle.address.destroy');

    // client
    Route::get('/client', [ClientController::class, 'index'])->name('client.index');
    Route::get('/client/add', [ClientController::class, 'add'])->name('client.add');
    Route::post('/client/add', [ClientController::class, 'store'])->name('client.store');
    Route::get('/client/{id}/edit', [ClientController::class, 'edit'])->name('client.edit');
    Route::put('/client/{id}/edit', [ClientController::class, 'update'])->name('client.update');
    Route::delete('/client/{id}/destroy', [ClientController::class, 'destroy'])->name('client.destroy');
    Route::post('/client/{client_id}/address/manage', [ClientController::class, 'addressManage'])->name('client.address.manage');
    Route::delete('/client/{client_id}/address/{id}/destroy', [ClientController::class, 'addressDestroy'])->name('client.address.destroy');

    // logistic
    Route::get('/logistic', [LogisticController::class, 'index'])->name('logistic.index');
    Route::get('/logistic/add', [LogisticController::class, 'add'])->name('logistic.add');
    Route::post('/logistic/add', [LogisticController::class, 'store'])->name('logistic.store');
    Route::get('/logistic/{id}/edit', [LogisticController::class, 'edit'])->name('logistic.edit');
    Route::put('/logistic/{id}/edit', [LogisticController::class, 'update'])->name('logistic.update');
    Route::delete('/logistic/{id}/destroy', [LogisticController::class, 'destroy'])->name('logistic.destroy');
    Route::post('/logistic/{logistic_id}/address/manage', [LogisticController::class, 'addressManage'])->name('logistic.address.manage');
    Route::delete('/logistic/{logistic_id}/address/{id}/destroy', [LogisticController::class, 'addressDestroy'])->name('logistic.address.destroy');

    // Quotation
    Route::get('/quotation', [QuotationController::class, 'index'])->name('quotation.index');
    Route::get('/quotation/add', [QuotationController::class, 'add'])->name('quotation.add');
    Route::post('/quotation/add', [QuotationController::class, 'store'])->name('quotation.store');
    Route::get('/quotation/{id}/edit', [QuotationController::class, 'edit'])->name('quotation.edit');
    Route::get('/quotation/{id}/print', [QuotationController::class, 'print'])->name('quotation.print');
    Route::get('/quotation/{id}/download', [QuotationController::class, 'download'])->name('quotation.download');
    Route::put('/quotation/{id}/edit', [QuotationController::class, 'update'])->name('quotation.update');
    Route::delete('/quotation/{id}/destroy', [QuotationController::class, 'destroy'])->name('quotation.destroy');

    // Purchase Order
    // -- from Client
    Route::get('/purchase', [PurchaseOrderController::class, 'index'])->name('purchase.index');
    Route::get('/purchase/add', [PurchaseOrderController::class, 'add'])->name('purchase.add');
    Route::post('/purchase/add', [PurchaseOrderController::class, 'store'])->name('purchase.store');
    Route::get('/purchase/{id}', [PurchaseOrderController::class, 'show'])->name('purchase.show');
    Route::get('/purchase/{id}/edit', [PurchaseOrderController::class, 'edit'])->name('purchase.edit');
    Route::put('/purchase/{id}/edit', [PurchaseOrderController::class, 'update'])->name('purchase.update');
    Route::delete('/purchase/{id}/destroy', [PurchaseOrderController::class, 'destroy'])->name('purchase.destroy');
    // -- Principle
    Route::get('/purchase/{id}/process', [ProcessPurchaseController::class, 'index'])->name('purchase.process.index');
    Route::get('/purchase/{id}/process/add', [ProcessPurchaseController::class, 'add'])->name('purchase.process.add');
    Route::post('/purchase/{id}/process/add', [ProcessPurchaseController::class, 'store'])->name('purchase.process.store');
    Route::get('/purchase/{id}/process/{process_id}/edit', [ProcessPurchaseController::class, 'edit'])->name('purchase.process.edit');
    Route::put('/purchase/{id}/process/{process_id}/edit', [ProcessPurchaseController::class, 'update'])->name('purchase.process.update');
    Route::delete('/purchase/{id}/process/{process_id}/destroy', [ProcessPurchaseController::class, 'destroy'])->name('purchase.process.destroy');

    // Packaging
    Route::get('/packaging', [PackagingController::class, 'index'])->name('packaging.index');
    Route::post('/packaging/add', [PackagingController::class, 'store'])->name('packaging.store');
    Route::put('/packaging/{id}/edit', [PackagingController::class, 'update'])->name('packaging.update');
    Route::delete('/packaging/{id}/destroy', [PackagingController::class, 'destroy'])->name('packaging.destroy');
});

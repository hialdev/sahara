<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AccountingController;
use App\Http\Controllers\AccountTypeController;
use App\Http\Controllers\AJAXController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\LogisticController;
use App\Http\Controllers\PackagingController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PrincipleController;
use App\Http\Controllers\ProcessPurchaseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\ReportController;
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
        Route::get('/address/{id}', [AJAXController::class, 'getAddressDetails']);
        Route::get('/principle', [AJAXController::class, 'getPrinciples']);
        Route::get('/principle/{id}', [AJAXController::class, 'getPrincipleDetails']);
        Route::get('/principle/address/{id}', [AJAXController::class, 'getPrincipleAddressDetails']);
        Route::get('/product', [AJAXController::class, 'getProducts']);
        Route::get('/packaging', [AJAXController::class, 'getPackagings']);
        Route::post('/product/add', [AJAXController::class, 'storeProduct']);
        Route::get('/product/{id}', [AJAXController::class, 'getProductDetails']);
        Route::get('/packaging/satuan/{satuan_id}', [AJAXController::class, 'getPackagingBySatuan']);
        // Quotation
        Route::get('/quotation', [AJAXController::class, 'getQuotations']);
        Route::get('/quotation/client/{client_id}', [AJAXController::class, 'getQuotationClient']);
        Route::get('/quotation/{id}', [AJAXController::class, 'getQuotationDetails']);
    
        // Purchase
        Route::get('/purchase/products', [AJAXController::class, 'getPurchaseProducts']);
        Route::get('/purchase/{id}/process/{process_id}', [AJAXController::class, 'getProcessDetail']);
    
        // Invoice
        Route::get('/invoice/{id}', [AJAXController::class, 'getInvoiceDetails']);
        Route::get('/invoice/{id}/process/{process_id}', [AJAXController::class, 'getInvoiceProcessDetails']);

        // Invoice
        Route::get('/debt/{id}', [AJAXController::class, 'getDebtDetails']);
        Route::get('/debt/{id}/process/{process_id}', [AJAXController::class, 'getDebtProcessDetails']);
    });

    Route::get('/', [PageController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');

    // Product
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/add', [ProductController::class, 'add'])->name('product.add');
    Route::post('/product/add', [ProductController::class, 'store'])->name('product.store');
    Route::put('/product/{id}/edit', [ProductController::class, 'update'])->name('product.update');
    Route::get('/product/{id}/setting', [ProductController::class, 'setting'])->name('product.setting');
    Route::delete('/product/{id}/destroy', [ProductController::class, 'destroy'])->name('product.destroy');

    // Satuan
    Route::get('/satuan', [SatuanController::class, 'index'])->name('satuan.index');
    Route::post('/satuan/add', [SatuanController::class, 'store'])->name('satuan.store');
    Route::put('/satuan/{id}/edit', [SatuanController::class, 'update'])->name('satuan.update');
    Route::get('/satuan/{id}/setting', [SatuanController::class, 'setting'])->name('satuan.setting');
    Route::delete('/satuan/{id}/destroy', [SatuanController::class, 'destroy'])->name('satuan.destroy');

    // Principle
    Route::get('/principle', [PrincipleController::class, 'index'])->name('principle.index');
    Route::get('/principle/add', [PrincipleController::class, 'add'])->name('principle.add');
    Route::post('/principle/add', [PrincipleController::class, 'store'])->name('principle.store');
    Route::get('/principle/{id}/edit', [PrincipleController::class, 'edit'])->name('principle.edit');
    Route::put('/principle/{id}/edit', [PrincipleController::class, 'update'])->name('principle.update');
    Route::get('/principle/{id}/setting', [PrincipleController::class, 'setting'])->name('principle.setting');
    Route::delete('/principle/{id}/destroy', [PrincipleController::class, 'destroy'])->name('principle.destroy');
    Route::post('/principle/{principle_id}/address/manage', [PrincipleController::class, 'addressManage'])->name('principle.address.manage');
    Route::delete('/principle/{principle_id}/address/{id}/destroy', [PrincipleController::class, 'addressDestroy'])->name('principle.address.destroy');

    // client
    Route::get('/client', [ClientController::class, 'index'])->name('client.index');
    Route::get('/client/add', [ClientController::class, 'add'])->name('client.add');
    Route::post('/client/add', [ClientController::class, 'store'])->name('client.store');
    Route::get('/client/{id}/edit', [ClientController::class, 'edit'])->name('client.edit');
    Route::put('/client/{id}/edit', [ClientController::class, 'update'])->name('client.update');
    Route::get('/client/{id}/setting', [ClientController::class, 'setting'])->name('client.setting');
    Route::delete('/client/{id}/destroy', [ClientController::class, 'destroy'])->name('client.destroy');
    Route::post('/client/{client_id}/address/manage', [ClientController::class, 'addressManage'])->name('client.address.manage');
    Route::delete('/client/{client_id}/address/{id}/destroy', [ClientController::class, 'addressDestroy'])->name('client.address.destroy');

    // logistic
    Route::get('/logistic', [LogisticController::class, 'index'])->name('logistic.index');
    Route::get('/logistic/add', [LogisticController::class, 'add'])->name('logistic.add');
    Route::post('/logistic/add', [LogisticController::class, 'store'])->name('logistic.store');
    Route::get('/logistic/{id}/edit', [LogisticController::class, 'edit'])->name('logistic.edit');
    Route::put('/logistic/{id}/edit', [LogisticController::class, 'update'])->name('logistic.update');
    Route::get('/logistic/{id}/setting', [LogisticController::class, 'setting'])->name('logistic.setting');
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
    Route::get('/quotation/{id}/setting', [QuotationController::class, 'setting'])->name('quotation.setting');
    Route::delete('/quotation/{id}/destroy', [QuotationController::class, 'destroy'])->name('quotation.destroy');

    // Purchase Order
    // -- from Client
    Route::get('/purchase', [PurchaseOrderController::class, 'index'])->name('purchase.index');
    Route::get('/purchase/processes', [PurchaseOrderController::class, 'process'])->name('purchase.process');
    Route::get('/purchase/deleted', [PurchaseOrderController::class, 'indexDeleted'])->name('purchase.index.deleted');
    Route::get('/purchase/add', [PurchaseOrderController::class, 'add'])->name('purchase.add');
    Route::post('/purchase/add', [PurchaseOrderController::class, 'store'])->name('purchase.store');
    Route::get('/purchase/{id}', [PurchaseOrderController::class, 'show'])->name('purchase.show');
    Route::get('/purchase/{id}/deleted', [PurchaseOrderController::class, 'showDeleted'])->name('purchase.show.deleted');
    Route::post('/purchase/{id}/invoice', [PurchaseOrderController::class, 'invoice'])->name('purchase.invoice.generate');
    Route::get('/purchase/{id}/edit', [PurchaseOrderController::class, 'edit'])->name('purchase.edit');
    Route::put('/purchase/{id}/edit', [PurchaseOrderController::class, 'update'])->name('purchase.update');
    Route::delete('/purchase/{id}/destroy', [PurchaseOrderController::class, 'destroy'])->name('purchase.destroy');
    Route::delete('/purchase/{id}/deleted/destroy', [PurchaseOrderController::class, 'destroyDeleted'])->name('purchase.destroy.deleted');
    Route::post('/purchase/{id}/restore', [PurchaseOrderController::class, 'restore'])->name('purchase.restore');
    // -- Process purchase
    Route::get('/purchase/{id}/process', [ProcessPurchaseController::class, 'index'])->name('purchase.process.index');
    Route::get('/purchase/{id}/process/add', [ProcessPurchaseController::class, 'add'])->name('purchase.process.add');
    Route::post('/purchase/{id}/process/add', [ProcessPurchaseController::class, 'store'])->name('purchase.process.store');
    Route::get('/purchase/{id}/process/{process_id}/edit', [ProcessPurchaseController::class, 'edit'])->name('purchase.process.edit');
    Route::post('/purchase/{id}/process/{process_id}/edit', [ProcessPurchaseController::class, 'update'])->name('purchase.process.update');
    Route::post('/purchase/{id}/process/{process_id}/processing', [ProcessPurchaseController::class, 'processing'])->name('purchase.process.processing');
    Route::post('/purchase/{id}/process/{process_id}/finish', [ProcessPurchaseController::class, 'finish'])->name('purchase.process.finish');
    Route::post('/purchase/{id}/process/{process_id}/debt', [ProcessPurchaseController::class, 'debt'])->name('purchase.process.debt');
    Route::delete('/purchase/{id}/process/{process_id}/destroy', [ProcessPurchaseController::class, 'destroy'])->name('purchase.process.destroy');

    // Packaging
    Route::get('/packaging', [PackagingController::class, 'index'])->name('packaging.index');
    Route::post('/packaging/add', [PackagingController::class, 'store'])->name('packaging.store');
    Route::put('/packaging/{id}/edit', [PackagingController::class, 'update'])->name('packaging.update');
    Route::get('/packaging/{id}/setting', [PackagingController::class, 'setting'])->name('packaging.setting');
    Route::delete('/packaging/{id}/destroy', [PackagingController::class, 'destroy'])->name('packaging.destroy');

    // Invoice
    Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoice.index');
    Route::get('/invoice/{id}', [InvoiceController::class, 'show'])->name('invoice.show');
    Route::get('/invoice/{id}/print', [InvoiceController::class, 'print'])->name('invoice.print');
    Route::get('/invoice/{id}/download', [InvoiceController::class, 'download'])->name('invoice.download');
    Route::delete('/invoice/{id}/delete', [InvoiceController::class, 'delete'])->name('invoice.delete');
    Route::delete('/invoice/{id}/destroy', [InvoiceController::class, 'destroy'])->name('invoice.destroy');
    Route::get('/invoice/{id}/process', [InvoiceController::class, 'process'])->name('invoice.process.index');
    Route::post('/invoice/{id}/process/add', [InvoiceController::class, 'processAdd'])->name('invoice.process.store');
    Route::get('/invoice/{id}/process/{process_id}', [InvoiceController::class, 'processShow'])->name('invoice.process.show');
    Route::post('/invoice/{id}/process/{process_id}/jurnal', [InvoiceController::class, 'makeJurnal'])->name('invoice.process.jurnal');
    Route::post('/invoice/{id}/process/{process_id}/edit', [InvoiceController::class, 'processUpdate'])->name('invoice.process.update');
    Route::delete('/invoice/{id}/process/{process_id}/destroy', [InvoiceController::class, 'processDestroy'])->name('invoice.process.destroy');

    // Debt
    Route::get('/debt', [DebtController::class, 'index'])->name('debt.index');
    Route::get('/debt/{id}', [DebtController::class, 'show'])->name('debt.show');
    Route::get('/debt/{id}/print', [DebtController::class, 'print'])->name('debt.print');
    Route::get('/debt/{id}/download', [DebtController::class, 'download'])->name('debt.download');
    Route::delete('/debt/{id}/delete', [DebtController::class, 'delete'])->name('debt.delete');
    Route::delete('/debt/{id}/destroy', [DebtController::class, 'destroy'])->name('debt.destroy');
    Route::get('/debt/{id}/process', [DebtController::class, 'process'])->name('debt.process.index');
    Route::post('/debt/{id}/process/add', [DebtController::class, 'processAdd'])->name('debt.process.store');
    Route::get('/debt/{id}/process/{process_id}', [DebtController::class, 'processShow'])->name('debt.process.show');
    Route::post('/debt/{id}/process/{process_id}/jurnal', [DebtController::class, 'makeJurnal'])->name('debt.process.jurnal');
    Route::post('/debt/{id}/process/{process_id}/edit', [DebtController::class, 'processUpdate'])->name('debt.process.update');
    Route::delete('/debt/{id}/process/{process_id}/destroy', [DebtController::class, 'processDestroy'])->name('debt.process.destroy');

    Route::get('/account-type', [AccountTypeController::class, 'index'])->name('account_type.index');
    Route::post('/account-type/add', [AccountTypeController::class, 'store'])->name('account_type.store');
    Route::get('/account-type/{id}', [AccountTypeController::class, 'show'])->name('account_type.show');
    Route::get('/account-type/{id}/setting', [AccountTypeController::class, 'setting'])->name('account_type.setting');
    Route::put('/account-type/{id}/edit', [AccountTypeController::class, 'update'])->name('account_type.update');
    Route::delete('/account-type/{id}/destroy', [AccountTypeController::class, 'destroy'])->name('account_type.destroy');
    
    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::get('/account/{id}', [AccountController::class, 'show'])->name('account.show');
    Route::post('/account/add', [AccountController::class, 'store'])->name('account.store');
    Route::put('/account/{id}/edit', [AccountController::class, 'update'])->name('account.update');
    Route::get('/account/{id}/setting', [AccountController::class, 'setting'])->name('account.setting');
    Route::delete('/account/{id}/destroy', [AccountController::class, 'destroy'])->name('account.destroy');

    Route::get('/jurnal', [JurnalController::class, 'index'])->name('jurnal.index');
    Route::get('/jurnal/add', [JurnalController::class, 'add'])->name('jurnal.add');
    Route::post('/jurnal/add', [JurnalController::class, 'store'])->name('jurnal.store');
    Route::get('/jurnal/{id}', [JurnalController::class, 'show'])->name('jurnal.show');
    Route::put('/jurnal/{id}/edit', [JurnalController::class, 'update'])->name('jurnal.update');
    Route::delete('/jurnal/{id}/destroy', [JurnalController::class, 'destroy'])->name('jurnal.destroy');
    Route::post('/jurnal/close-year', [JurnalController::class, 'closeYear'])->name('jurnal.closeYear');
    Route::post('/jurnal/open-year', [JurnalController::class, 'openYear'])->name('jurnal.openYear');

    //---------------
    // Reports
    //---------------
    Route::get('/report/balance', [ReportController::class, 'balance'])->name('report.balance');
    Route::get('/report/balance/print', [ReportController::class, 'balancePrint'])->name('report.balance.print');
    Route::get('/report/balance/download', [ReportController::class, 'balanceDownload'])->name('report.balance.download');
    
    Route::get('/report/cash-flow', [ReportController::class, 'cashFlow'])->name('report.cashFlow');
    Route::get('/report/cash-flow/print', [ReportController::class, 'cashFlowPrint'])->name('report.cashFlow.print');
    Route::get('/report/cash-flow/download', [ReportController::class, 'cashFlowDownload'])->name('report.cashFlow.download');
    
    Route::get('/report/general-ledger', [ReportController::class, 'generalLedger'])->name('report.generalLedger');
    Route::get('/report/general-ledger/print', [ReportController::class, 'generalLedgerPrint'])->name('report.generalLedger.print');
    Route::get('/report/general-ledger/download', [ReportController::class, 'generalLedgerDownload'])->name('report.generalLedger.download');
    
    Route::get('/report/changes-in-equity', [ReportController::class, 'changesInEquity'])->name('report.changesInEquity');
    Route::get('/report/changes-in-equity/print', [ReportController::class, 'changesInEquityPrint'])->name('report.changesInEquity.print');
    Route::get('/report/changes-in-equity/download', [ReportController::class, 'changesInEquityDownload'])->name('report.changesInEquity.download');
    
    Route::get('/report/accounts-receivable-payable', [ReportController::class, 'accountsReceivableAndPayable'])->name('report.accountsReceivableAndPayable');
    Route::get('/report/accounts-receivable-payable/print', [ReportController::class, 'accountsReceivableAndPayablePrint'])->name('report.accountsReceivableAndPayable.print');
    Route::get('/report/accounts-receivable-payable/donwload', [ReportController::class, 'accountsReceivableAndPayableDownload'])->name('report.accountsReceivableAndPayable.download');
    
    Route::get('/report/income-statement', [ReportController::class, 'incomeStatement'])->name('report.incomeStatement');
    Route::get('/report/income-statement/print', [ReportController::class, 'incomeStatementPrint'])->name('report.incomeStatement.print');
    Route::get('/report/income-statement/download', [ReportController::class, 'incomeStatementDownload'])->name('report.incomeStatement.download');

});

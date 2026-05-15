<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProcurementInvoiceController;
use App\Http\Controllers\ProcurementRequestController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'auth'])->name('auth');
Route::post('/login', [HomeController::class, 'login'])->name('login');

Route::middleware('auth.user')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/logout', [HomeController::class, 'logout'])->name('logout');

    Route::group(['prefix' => 'divisions'], function () {
        Route::get('/', [DivisionController::class, 'index'])->name('division.index');
        Route::post('/datatable', [DivisionController::class, 'datatableAjax'])->name('division.datatable');
        Route::post('/', [DivisionController::class, 'store'])->name('division.store');
        Route::put('/{id}', [DivisionController::class, 'update'])->name('division.update');
        Route::delete('/{id}', [DivisionController::class, 'destroy'])->name('division.destroy');
    });

    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', [CategoryController::class, 'index'])->name('category.index');
        Route::post('/datatable', [CategoryController::class, 'datatableAjax'])->name('category.datatable');
        Route::post('/', [CategoryController::class, 'store'])->name('category.store');
        Route::put('/{id}', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
    });

    Route::group(['prefix' => 'vendors'], function () {
        Route::get('/', [VendorController::class, 'index'])->name('vendor.index');
        Route::post('/datatable', [VendorController::class, 'datatableAjax'])->name('vendor.datatable');
        Route::post('/', [VendorController::class, 'store'])->name('vendor.store');
        Route::put('/{id}', [VendorController::class, 'update'])->name('vendor.update');
        Route::delete('/{id}', [VendorController::class, 'destroy'])->name('vendor.destroy');
    });

    Route::group(['prefix' => 'products'], function () {
        Route::get('/', [ProductController::class, 'index'])->name('product.index');
        Route::post('/datatable', [ProductController::class, 'datatableAjax'])->name('product.datatable');
        Route::get('/options', [ProductController::class, 'options'])->name('product.options');
        Route::post('/', [ProductController::class, 'store'])->name('product.store');
        Route::put('/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
    });

    Route::group(['prefix' => 'procurement-requests'], function () {
        Route::get('/staff', [ProcurementRequestController::class, 'staffIndex'])->name('procurement-request.staff');
        Route::get('/staff-list', [ProcurementRequestController::class, 'staffList'])->name('procurement-list-request.staff');
        Route::get('/manager', [ProcurementRequestController::class, 'managerIndex'])->name('procurement-request.manager');
        Route::get('/admin', [ProcurementRequestController::class, 'adminIndex'])->name('procurement-request.admin');
        Route::post('/datatable', [ProcurementRequestController::class, 'datatableAjax'])->name('procurement-request.datatable');
        Route::post('/products-datatable', [ProcurementRequestController::class, 'productsDataTable'])->name('procurement-request.products-datatable');
        Route::get('/categories-options', [ProcurementRequestController::class, 'categoriesOptions'])->name('procurement-request.categories-options');
        Route::post('/', [ProcurementRequestController::class, 'store'])->name('procurement-request.store');
        Route::get('/{id}', [ProcurementRequestController::class, 'show'])->name('procurement-request.show');
        Route::put('/{id}/manager-review', [ProcurementRequestController::class, 'managerReview'])->name('procurement-request.manager-review');
        Route::put('/{id}/admin-review', [ProcurementRequestController::class, 'adminReview'])->name('procurement-request.admin-review');
        Route::put('/{id}/progress', [ProcurementRequestController::class, 'progress'])->name('procurement-request.progress');

        // Invoice & Payment routes
        Route::post('/{id}/place-order',             [ProcurementInvoiceController::class, 'placeOrder'])->name('procurement-invoice.place-order');
        Route::post('/{id}/goods-receipt',           [ProcurementInvoiceController::class, 'confirmGoodsReceipt'])->name('procurement-invoice.goods-receipt');
        Route::post('/{id}/invoice',                 [ProcurementInvoiceController::class, 'uploadInvoice'])->name('procurement-invoice.upload-invoice');
        Route::put('/{id}/invoice/dispute/resolve',  [ProcurementInvoiceController::class, 'resolveDispute'])->name('procurement-invoice.resolve-dispute');
        Route::put('/{id}/invoice/verify',           [ProcurementInvoiceController::class, 'verifyInvoice'])->name('procurement-invoice.verify-invoice');
        Route::post('/{id}/payment/approve',         [ProcurementInvoiceController::class, 'approvePayment'])->name('procurement-invoice.approve-payment');
        Route::put('/{id}/payment/mark-paid',        [ProcurementInvoiceController::class, 'markAsPaid'])->name('procurement-invoice.mark-paid');
        Route::get('/{id}/timeline',                 [ProcurementInvoiceController::class, 'getTimeline'])->name('procurement-invoice.timeline');
        Route::get('/{id}/purchase-order',           [ProcurementInvoiceController::class, 'getPurchaseOrder'])->name('procurement-invoice.purchase-order');
        Route::get('/{id}/goods-receipt',            [ProcurementInvoiceController::class, 'getGoodsReceipt'])->name('procurement-invoice.get-goods-receipt');
        Route::get('/{id}/invoice',                  [ProcurementInvoiceController::class, 'getInvoiceDetail'])->name('procurement-invoice.get-invoice');
        Route::get('/{id}/payment',                  [ProcurementInvoiceController::class, 'getPaymentDetail'])->name('procurement-invoice.get-payment');
    });

    Route::group(['prefix' => 'roles'], function () {
        Route::get('/', [RoleController::class, 'index'])->name('role.index');
        Route::post('/datatable', [RoleController::class, 'datatableAjax'])->name('role.datatable');
        Route::post('/', [RoleController::class, 'store'])->name('role.store');
        Route::put('/{id}', [RoleController::class, 'update'])->name('role.update');
        Route::delete('/{id}', [RoleController::class, 'destroy'])->name('role.destroy');
        Route::get('/{roleId}/menus', [RoleController::class, 'getRoleMenus'])->name('role.menus.index');
        Route::post('/{roleId}/menus', [RoleController::class, 'assignMenus'])->name('role.menus.assign');
        Route::delete('/{roleId}/menus/{menuId}', [RoleController::class, 'removeMenu'])->name('role.menus.remove');
    });
});

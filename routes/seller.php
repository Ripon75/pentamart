<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Seller\AuthController;
use App\Http\Controllers\Seller\OrderController;
use App\Http\Controllers\Seller\ProductController;
use App\Http\Controllers\Seller\DashboardController;
use App\Http\Controllers\Seller\ProductPriceLogController;


Route::get('/login',  [AuthController::class, 'loginCreate'])->name('login.create');
Route::post('/login', [AuthController::class, 'loginStore'])->name('login.store');

Route::middleware(['auth', 'role:sell-partner'])->group(function() {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // Order route
    Route::get('/orders',                      [OrderController::class, 'index'])->name('orders.index')->middleware(['permission:orders-read']);
    Route::get('/orders/manual/create',        [OrderController::class, 'manualCreate'])->name('orders.manual.create')->middleware(['permission:orders-create']);
    Route::post('/orders/manual',              [OrderController::class, 'manualStore'])->name('orders.manual.store')->middleware(['permission:orders-create']);
    Route::post('/orders',                     [OrderController::class, 'store'])->name('orders.store')->middleware(['permission:orders-create']);
    Route::get('/orders/refund/{orderId}/{paymentGateway}', [OrderController::class, 'refund'])->name('orders.refund');
    Route::post('/orders/refund',              [OrderController::class, 'refundStore'])->name('orders.refund.store');
    Route::get('/orders/{id}',                 [OrderController::class, 'show'])->name('orders.show')->middleware(['permission:orders-read']);
    Route::get('/orders/{id}/edit',            [OrderController::class, 'edit'])->name('orders.edit')->middleware(['permission:orders-update']);
    Route::get('/orders/multiple/invoice',     [OrderController::class, 'multipleInvoice'])->name('orders.multiple.invoice')->middleware(['permission:orders-read']);
    Route::get('/orders/{id}/invoice',         [OrderController::class, 'invoice'])->name('orders.invoice')->middleware(['permission:orders-read']);
    Route::get('/orders/{id}/shipping/label',  [OrderController::class, 'shippingLabel'])->name('orders.shipping.label')->middleware(['permission:orders-read']);
    Route::get('/orders/{id}/purchase/order',  [OrderController::class, 'purchaseOrder'])->name('orders.purchase.order');
    Route::put('/orders/{id}',                 [OrderController::class, 'update'])->name('orders.update')->middleware(['permission:orders-update']);
    Route::post('/order-items/remove',         [OrderController::class, 'orderItemRemove'])->name('orders.item.remove')->middleware(['permission:orders-update']);
    Route::get('/orders/bulk/onclogy',   [OrderController::class, 'bulkOrderCreate'])->name('orders.bulk.onclogy.create')->middleware(['permission:orders-create']);
    Route::post('/orders/bulk/onclogy',  [OrderController::class, 'bulkOrderStore'])->name('orders.bulk.onclogy.store')->middleware(['permission:orders-create']);
    Route::get('order/report',           [ReportController::class, 'orderReport'])->name('orders.report')->middleware(['permission:sell-reports-read']);
    Route::get('orders/processing/{id}', [OrderProcessingController::class, 'orderProcessing'])->name('orders.processing')->middleware(['permission:orders-create']);
    // Show prescription
    Route::get('/prescriptions/{id}', [OrderController::class, 'prescriptionShow'])->name('prescription.show')->middleware(['permission:orders-read']);
    Route::post('/orders/make/paid',  [Ordercontroller::class, 'makePaid'])->name('make.paid')->middleware(['permission:orders-update']);
    Route::post('/orders/send',       [Ordercontroller::class, 'sendOrderMedipos'])->name('send.order')->middleware(['permission:send-orders-create']);
    Route::post('/orders/status/update', [Ordercontroller::class, 'statusUpdate'])->name('status.update')->middleware(['permission:send-orders-create']);
    Route::get('/orders/upload/prescription/{id}', [Ordercontroller::class, 'uploadPrescription'])->name('prescription.upload')->middleware(['permission:orders-update']);
    Route::post('/orders/upload/prescription/{id}', [Ordercontroller::class, 'uploadPrescriptionStore'])->name('prescription.store')->middleware(['permission:orders-update']);

    // All product route
    Route::get('/products',           [ProductController::class, 'index'])->name('products.index')->middleware(['permission:products-read']);
    Route::get('/products/create',    [ProductController::class, 'create'])->name('products.create')->middleware(['permission:products-create']);
    // Route::get('/products/bulk',      [ProductController::class, 'bulk'])->name('products.bulk')->middleware(['permission:product-bulk-create']);
    // Route::post('/products/bulk',     [ProductController::class, 'bulkUpload'])->name('products.bulk.upload')->middleware(['permission:product-bulk-create']);
    Route::post('/products',          [ProductController::class, 'store'])->name('products.store')->middleware(['permission:products-create']);
    Route::get('/products/{id}',      [ProductController::class, 'show'])->name('products.show')->middleware(['permission:products-read']);
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit')->middleware(['permission:products-update']);
    Route::put('/products/{id}',      [ProductController::class, 'update'])->name('products.update')->middleware(['permission:products-update']);
    Route::delete('/products/{id}',   [ProductController::class, 'delete'])->name('products.delete')->middleware(['permission:products-delete']);

    // Price logs route
    Route::get('products/price/logs', [ProductPriceLogController::class, 'index'])->name('logs.index')->middleware(['permission:price-log-read']);
});
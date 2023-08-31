<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\StatusController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\DistrictController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PaymentGatewayController;

Route::middleware(['auth'])->group(function() {
    // Dashboard route
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard')->middleware(['permission:dashboards-read']);

    // All brand route
    Route::get('districts',           [DistrictController::class, 'index'])->name('districts.index')->middleware(['permission:districts-read']);
    Route::get('districts/create',    [DistrictController::class, 'create'])->name('districts.create')->middleware(['permission:districts-create']);
    Route::post('districts',          [DistrictController::class, 'store'])->name('districts.store')->middleware(['permission:districts-create']);
    Route::get('districts/{id}/edit', [DistrictController::class, 'edit'])->name('districts.edit')->middleware(['permission:districts-update']);
    Route::put('districts/{id}',      [DistrictController::class, 'update'])->name('districts.update')->middleware(['permission:districts-update']);

    // All brand route
    Route::get('sliders',           [SliderController::class, 'index'])->name('sliders.index')->middleware(['permission:sliders-read']);
    Route::get('sliders/create',    [SliderController::class, 'create'])->name('sliders.create')->middleware(['permission:sliders-create']);
    Route::post('sliders',          [SliderController::class, 'store'])->name('sliders.store')->middleware(['permission:sliders-create']);
    Route::get('sliders/{id}/edit', [SliderController::class, 'edit'])->name('sliders.edit')->middleware(['permission:sliders-update']);
    Route::put('sliders/{id}',      [SliderController::class, 'update'])->name('sliders.update')->middleware(['permission:sliders-update']);

    // All brand route
    Route::get('brands',           [BrandController::class, 'index'])->name('brands.index')->middleware(['permission:brands-read']);
    Route::get('brands/create',    [BrandController::class, 'create'])->name('brands.create')->middleware(['permission:brands-create']);
    Route::post('brands',          [BrandController::class, 'store'])->name('brands.store')->middleware(['permission:brands-create']);
    Route::get('brands/{id}/edit', [BrandController::class, 'edit'])->name('brands.edit')->middleware(['permission:brands-update']);
    Route::put('brands/{id}',      [BrandController::class, 'update'])->name('brands.update')->middleware(['permission:brands-update']);

    // All category route
    Route::get('categories',           [CategoryController::class, 'index'])->name('categories.index')->middleware(['permission:categories-read']);
    Route::get('categories/create',    [CategoryController::class, 'create'])->name('categories.create')->middleware(['permission:categories-create']);
    Route::post('categories',          [CategoryController::class, 'store'])->name('categories.store')->middleware(['permission:categories-create']);
    Route::get('categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit')->middleware(['permission:categories-update']);
    Route::put('categories/{id}',      [CategoryController::class, 'update'])->name('categories.update')->middleware(['permission:categories-update']);

    // All offer route
    Route::get('offers',           [OfferController::class, 'index'])->name('offers.index')->middleware(['permission:offers-read']);
    Route::get('offers/create',    [OfferController::class, 'create'])->name('offers.create')->middleware(['permission:offers-create']);
    Route::post('offers',          [OfferController::class, 'store'])->name('offers.store')->middleware(['permission:offers-create']);
    Route::get('offers/{id}/edit', [OfferController::class, 'edit'])->name('offers.edit')->middleware(['permission:offers-update']);
    Route::put('offers/{id}',      [OfferController::class, 'update'])->name('offers.update')->middleware(['permission:offers-update']);

    // All product route
    Route::get('products',           [ProductController::class, 'index'])->name('products.index')->middleware(['permission:products-read']);
    Route::get('products/create',    [ProductController::class, 'create'])->name('products.create')->middleware(['permission:products-create']);
    Route::get('products/bulk',      [ProductController::class, 'bulk'])->name('products.bulk')->middleware(['permission:product-bulk-create']);
    Route::post('products/bulk',     [ProductController::class, 'bulkUpload'])->name('products.bulk.upload')->middleware(['permission:product-bulk-create']);
    Route::post('products',          [ProductController::class, 'store'])->name('products.store')->middleware(['permission:products-create']);
    Route::get('products/{id}',      [ProductController::class, 'show'])->name('products.show')->middleware(['permission:products-read']);
    Route::get('products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit')->middleware(['permission:products-update']);
    Route::put('products/{id}',      [ProductController::class, 'update'])->name('products.update')->middleware(['permission:products-update']);
    Route::delete('products/{id}',   [ProductController::class, 'delete'])->name('products.delete')->middleware(['permission:products-delete']);

    // Order report
    Route::get('orders/report', [ReportController::class, 'orderReport'])->name('orders.report')->middleware(['permission:sell-reports-read']);

    // Order route
    Route::get('orders',               [OrderController::class, 'index'])->name('orders.index')->middleware(['permission:orders-read']);
    Route::get('orders/manual/create', [OrderController::class, 'manualCreate'])->name('orders.manual.create')->middleware(['permission:orders-create']);
    Route::post('orders/manual',       [OrderController::class, 'manualStore'])->name('orders.manual.store')->middleware(['permission:orders-create']);
    Route::post('orders',              [OrderController::class, 'store'])->name('orders.store')->middleware(['permission:orders-create']);
    Route::post('orders/refund',       [OrderController::class, 'refundStore'])->name('orders.refund.store');
    Route::get('orders/{id}',          [OrderController::class, 'show'])->name('orders.show')->middleware(['permission:orders-read']);
    Route::get('orders/{id}/edit',     [OrderController::class, 'edit'])->name('orders.edit')->middleware(['permission:orders-update']);
    Route::get('orders/{id}/invoice',  [OrderController::class, 'invoice'])->name('orders.invoice')->middleware(['permission:orders-read']);
    Route::put('orders/{id}',          [OrderController::class, 'update'])->name('orders.update')->middleware(['permission:orders-update']);
    Route::post('order/items/remove',  [OrderController::class, 'orderItemRemove'])->name('orders.item.remove')->middleware(['permission:orders-update']);
    Route::post('orders/make/paid',    [Ordercontroller::class, 'makePaid'])->name('make.paid')->middleware(['permission:orders-update']);

    // All payment gateway route
    Route::get('gateways/payment',           [PaymentGatewayController::class, 'index'])->name('payments.index')->middleware(['permission:payment-types-read']);
    Route::get('gateways/payment/create',    [PaymentGatewayController::class, 'create'])->name('payments.create')->middleware(['permission:payment-types-create']);
    Route::post('gateways/payment',          [PaymentGatewayController::class, 'store'])->name('payments.store')->middleware(['permission:payment-types-create']);
    Route::get('gateways/payment/{id}/edit', [PaymentGatewayController::class, 'edit'])->name('payments.edit')->middleware(['permission:payment-types-update']);
    Route::put('gateways/payment/{id}',      [PaymentGatewayController::class, 'update'])->name('payments.update')->middleware(['permission:payment-types-update']);

    // All coupon code route
    Route::get('coupons',           [CouponController::class, 'index'])->name('coupons.index')->middleware(['permission:coupons-read']);
    Route::get('coupons/create',    [CouponController::class, 'create'])->name('coupons.create')->middleware(['permission:coupons-create']);
    Route::post('coupons',          [CouponController::class, 'store'])->name('coupons.store')->middleware(['permission:coupons-create']);
    Route::get('coupons/{id}',      [CouponController::class, 'show'])->name('coupons.show')->middleware(['permission:coupons-read']);
    Route::get('coupons/{id}/edit', [CouponController::class, 'edit'])->name('coupons.edit')->middleware(['permission:coupons-update']);
    Route::put('coupons/{id}',      [CouponController::class, 'update'])->name('coupons.update')->middleware(['permission:coupons-update']);

    // All order status route
    Route::get('statuses',           [StatusController::class, 'index'])->name('statuses.index')->middleware(['permission:status-read']);
    Route::get('statuses/create',    [StatusController::class, 'create'])->name('statuses.create')->middleware(['permission:status-create']);
    Route::post('statuses',          [StatusController::class, 'store'])->name('statuses.store')->middleware(['permission:status-create']);
    Route::get('statuses/{id}/edit', [StatusController::class, 'edit'])->name('statuses.edit')->middleware(['permission:status-update']);
    Route::put('statuses/{id}',      [StatusController::class, 'update'])->name('statuses.update')->middleware(['permission:status-update']);

    // All role route
    Route::get('roles',           [RoleController::class, 'index'])->name('roles')->middleware(['permission:roles-read']);
    Route::get('roles/create',    [RoleController::class, 'create'])->name('roles.create')->middleware(['permission:roles-create']);
    Route::post('roles',          [RoleController::class, 'store'])->name('roles.store')->middleware(['permission:roles-create']);
    Route::get('roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit')->middleware(['permission:roles-update']);
    Route::put('roles/{id}',      [RoleController::class, 'update'])->name('roles.update')->middleware(['permission:roles-update']);

    // All permission route
    Route::get('permissions',           [PermissionController::class, 'index'])->name('permissions')->middleware(['permission:permissions-read']);
    Route::get('permissions/create',    [PermissionController::class, 'create'])->name('permissions.create')->middleware(['permission:permissions-create']);
    Route::post('permissions',          [PermissionController::class, 'store'])->name('permissions.store')->middleware(['permission:permissions-create']);
    Route::get('permissions/{id}/edit', [PermissionController::class, 'edit'])->name('permissions.edit')->middleware(['permission:permissions-update']);
    Route::put('permissions/{id}',      [PermissionController::class, 'update'])->name('permissions.update')->middleware(['permission:permissions-update']);

    // Section route
    Route::get('sections',           [SectionController::class, 'index'])->name('sections.index')->middleware(['permission:sections-read']);
    Route::get('sections/create',    [SectionController::class, 'create'])->name('sections.create')->middleware(['permission:sections-create']);
    Route::post('sections',          [SectionController::class, 'store'])->name('sections.store')->middleware(['permission:sections-create']);
    Route::get('sections/{id}',      [SectionController::class, 'show'])->name('sections.show')->middleware(['permission:sections-read']);
    Route::get('sections/{id}/edit', [SectionController::class, 'edit'])->name('sections.edit')->middleware(['permission:sections-update']);
    Route::put('sections/{id}',      [SectionController::class, 'update'])->name('sections.update')->middleware(['permission:sections-update']);

    // user route
    Route::get('users',           [UserController::class, 'index'])->name('users.index')->middleware(['permission:users-read']);
    Route::get('users/create',    [UserController::class, 'create'])->name('users.create')->middleware(['permission:users-create']);
    Route::post('users',          [UserController::class, 'store'])->name('users.store')->middleware(['permission:users-create']);
    Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware(['permission:users-update']);
    Route::put('users/{id}',      [UserController::class, 'update'])->name('users.update')->middleware(['permission:users-update']);
});

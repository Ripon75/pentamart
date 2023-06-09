<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\StatusController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PaymentGatewayController;
use App\Http\Controllers\Admin\DeliveryGatewayController;

Route::middleware(['auth'])->group(function() {
    // Dashboard route
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard')->middleware(['permission:dashboards-read']);

    // All brand route
    Route::get('areas',           [AreaController::class, 'index'])->name('areas.index')->middleware(['permission:areas-read']);
    Route::get('areas/create',    [AreaController::class, 'create'])->name('areas.create')->middleware(['permission:areas-create']);
    Route::post('areas',          [AreaController::class, 'store'])->name('areas.store')->middleware(['permission:areas-create']);
    Route::get('areas/{id}/edit', [AreaController::class, 'edit'])->name('areas.edit')->middleware(['permission:areas-update']);
    Route::put('areas/{id}',      [AreaController::class, 'update'])->name('areas.update')->middleware(['permission:areas-update']);

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

    // Order report
    Route::get('orders/report', [ReportController::class, 'orderReport'])->name('orders.report')->middleware(['permission:sell-reports-read']);

    // All payment gateway route
    Route::get('gateways/payment',           [PaymentGatewayController::class, 'index'])->name('payments.index')->middleware(['permission:payment-types-read']);
    Route::get('gateways/payment/create',    [PaymentGatewayController::class, 'create'])->name('payments.create')->middleware(['permission:payment-types-create']);
    Route::post('gateways/payment',          [PaymentGatewayController::class, 'store'])->name('payments.store')->middleware(['permission:payment-types-create']);
    Route::get('gateways/payment/{id}/edit', [PaymentGatewayController::class, 'edit'])->name('payments.edit')->middleware(['permission:payment-types-update']);
    Route::put('gateways/payment/{id}',      [PaymentGatewayController::class, 'update'])->name('payments.update')->middleware(['permission:payment-types-update']);

    // All delivery gateway route
    Route::get('gateways/delivery',           [DeliveryGatewayController::class, 'index'])->name('deliveries.index')->middleware(['permission:delivery-types-read']);
    Route::get('gateways/delivery/create',    [DeliveryGatewayController::class, 'create'])->name('deliveries.create')->middleware(['permission:delivery-types-create']);
    Route::post('gateways/delivery',          [DeliveryGatewayController::class, 'store'])->name('deliveries.store')->middleware(['permission:delivery-types-create']);
    Route::get('gateways/delivery/{id}/edit', [DeliveryGatewayController::class, 'edit'])->name('deliveries.edit')->middleware(['permission:delivery-types-update']);
    Route::put('gateways/delivery/{id}',      [DeliveryGatewayController::class, 'update'])->name('deliveries.update')->middleware(['permission:delivery-types-update']);

    // All coupon code route
    Route::get('coupons',           [CouponController::class, 'index'])->name('coupons.index')->middleware(['permission:coupons-read']);
    Route::get('coupons/create',    [CouponController::class, 'create'])->name('coupons.create')->middleware(['permission:coupons-create']);
    Route::post('coupons',          [CouponController::class, 'store'])->name('coupons.store')->middleware(['permission:coupons-create']);
    Route::get('coupons/{id}',      [CouponController::class, 'show'])->name('coupons.show')->middleware(['permission:coupons-read']);
    Route::get('coupons/{id}/edit', [CouponController::class, 'edit'])->name('coupons.edit')->middleware(['permission:coupons-update']);
    Route::put('coupons/{id}',      [CouponController::class, 'update'])->name('coupons.update')->middleware(['permission:coupons-update']);

    // All order status route
    Route::get('order/statuses',           [StatusController::class, 'index'])->name('order.statuses.index')->middleware(['permission:order-status-read']);
    Route::get('order/statuses/create',    [StatusController::class, 'create'])->name('order.statuses.create')->middleware(['permission:order-status-create']);
    Route::post('order/statuses',          [StatusController::class, 'store'])->name('order.statuses.store')->middleware(['permission:order-status-create']);
    Route::get('order/statuses/{id}/edit', [StatusController::class, 'edit'])->name('order.statuses.edit')->middleware(['permission:order-status-update']);
    Route::put('order/statuses/{id}',      [StatusController::class, 'update'])->name('order.statuses.update')->middleware(['permission:order-status-update']);

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

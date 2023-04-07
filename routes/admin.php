<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AppController;
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\FamilyController;
use App\Http\Controllers\Admin\GenericController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BSGSOfferController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DosageFormController;
use App\Http\Controllers\Admin\CouponCodeController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\OrderStatusController;
use App\Http\Controllers\Admin\BrandBannerController;
use App\Http\Controllers\Admin\SellPartnerController;
use App\Http\Controllers\Admin\ProductPackController;
use App\Http\Controllers\Admin\PurchaseOrderController;
use App\Http\Controllers\Admin\MedicalBannerController;
use App\Http\Controllers\Admin\PaymentGatewayController;
use App\Http\Controllers\Admin\DeliveryGatewayController;
use App\Http\Controllers\Admin\OrderProcessingController;
use App\Http\Controllers\Admin\ProductPriceLogController;

// admin login route
Route::get('/users/login',  [UserController::class, 'loginCreate'])->name('users.login.create');
Route::post('/users/login', [UserController::class, 'loginStore'])->name('users.login.store');

Route::middleware(['auth'])->group(function() {
    // Dashboard route
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard')->middleware(['permission:dashboards-read']);

    // All brand route
    Route::get('/areas',           [AreaController::class, 'index'])->name('areas.index')->middleware(['permission:areas-read']);
    Route::get('/areas/create',    [AreaController::class, 'create'])->name('areas.create')->middleware(['permission:areas-create']);
    Route::post('/areas',          [AreaController::class, 'store'])->name('areas.store')->middleware(['permission:areas-create']);
    Route::get('/areas/{id}',      [AreaController::class, 'show'])->name('areas.show')->middleware(['permission:areas-read']);
    Route::get('/areas/{id}/edit', [AreaController::class, 'edit'])->name('areas.edit')->middleware(['permission:areas-update']);
    Route::put('/areas/{id}',      [AreaController::class, 'update'])->name('areas.update')->middleware(['permission:areas-update']);

    // All brand route
    Route::get('/brands',           [BrandController::class, 'index'])->name('brands.index')->middleware(['permission:brands-read']);
    Route::get('/brands/create',    [BrandController::class, 'create'])->name('brands.create')->middleware(['permission:brands-create']);
    Route::post('/brands',          [BrandController::class, 'store'])->name('brands.store')->middleware(['permission:brands-create']);
    Route::get('/brands/{id}',      [BrandController::class, 'show'])->name('brands.show')->middleware(['permission:brands-read']);
    Route::get('/brands/{id}/edit', [BrandController::class, 'edit'])->name('brands.edit')->middleware(['permission:brands-update']);
    Route::put('/brands/{id}',      [BrandController::class, 'update'])->name('brands.update')->middleware(['permission:brands-update']);

    // All company route
    Route::get('/companies',           [CompanyController::class, 'index'])->name('companies.index')->middleware(['permission:companies-read']);
    Route::get('/companies/create',    [CompanyController::class, 'create'])->name('companies.create')->middleware(['permission:companies-create']);
    Route::post('/companies',          [CompanyController::class, 'store'])->name('companies.store')->middleware(['permission:companies-create']);
    Route::get('/companies/{id}',      [CompanyController::class, 'show'])->name('companies.show')->middleware(['permission:companies-read']);
    Route::get('/companies/{id}/edit', [CompanyController::class, 'edit'])->name('companies.edit')->middleware(['permission:companies-update']);
    Route::put('/companies/{id}',      [CompanyController::class, 'update'])->name('companies.update')->middleware(['permission:companies-update']);

    // All category route
    Route::get('/categories',           [CategoryController::class, 'index'])->name('categories.index')->middleware(['permission:categories-read']);
    Route::get('/categories/create',    [CategoryController::class, 'create'])->name('categories.create')->middleware(['permission:categories-create']);
    Route::post('/categories',          [CategoryController::class, 'store'])->name('categories.store')->middleware(['permission:categories-create']);
    Route::get('/categories/{id}',      [CategoryController::class, 'show'])->name('categories.show')->middleware(['permission:categories-read']);
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit')->middleware(['permission:categories-update']);
    Route::put('/categories/{id}',      [CategoryController::class, 'update'])->name('categories.update')->middleware(['permission:categories-update']);
    
    // All generic route
    Route::get('/generics',           [GenericController::class, 'index'])->name('generics.index')->middleware(['permission:generics-read']);
    Route::get('/generics/create',    [GenericController::class, 'create'])->name('generics.create')->middleware(['permission:generics-create']);
    Route::post('/generics',          [GenericController::class, 'store'])->name('generics.store')->middleware(['permission:generics-create']);
    Route::get('/generics/{id}',      [GenericController::class, 'show'])->name('generics.show')->middleware(['permission:generics-read']);
    Route::get('/generics/{id}/edit', [GenericController::class, 'edit'])->name('generics.edit')->middleware(['permission:generics-update']);
    Route::put('/generics/{id}',      [GenericController::class, 'update'])->name('generics.update')->middleware(['permission:generics-update']);
    
    // All dosage form route
    Route::get('/dosage-forms',           [DosageFormController::class, 'index'])->name('dosage-forms.index')->middleware(['permission:dosage-forms-read']);
    Route::get('/dosage-forms/create',    [DosageFormController::class, 'create'])->name('dosage-forms.create')->middleware(['permission:dosage-forms-create']);
    Route::post('/dosage-forms',          [DosageFormController::class, 'store'])->name('dosage-forms.store')->middleware(['permission:dosage-forms-create']);
    Route::get('/dosage-forms/{id}',      [DosageFormController::class, 'show'])->name('dosage-forms.show')->middleware(['permission:dosage-forms-read']);
    Route::get('/dosage-forms/{id}/edit', [DosageFormController::class, 'edit'])->name('dosage-forms.edit')->middleware(['permission:dosage-forms-update']);
    Route::put('/dosage-forms/{id}',      [DosageFormController::class, 'update'])->name('dosage-forms.update')->middleware(['permission:dosage-forms-update']);
    
    // All product route
    Route::get('/products',           [ProductController::class, 'index'])->name('products.index')->middleware(['permission:products-read']);
    Route::get('/products/create',    [ProductController::class, 'create'])->name('products.create')->middleware(['permission:products-create']);
    Route::get('/products/bulk',      [ProductController::class, 'bulk'])->name('products.bulk')->middleware(['permission:product-bulk-create']);
    Route::post('/products/bulk',     [ProductController::class, 'bulkUpload'])->name('products.bulk.upload')->middleware(['permission:product-bulk-create']);
    Route::post('/products',          [ProductController::class, 'store'])->name('products.store')->middleware(['permission:products-create']);
    Route::get('/products/{id}',      [ProductController::class, 'show'])->name('products.show')->middleware(['permission:products-read']);
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit')->middleware(['permission:products-update']);
    Route::put('/products/{id}',      [ProductController::class, 'update'])->name('products.update')->middleware(['permission:products-update']);
    Route::delete('/products/{id}',   [ProductController::class, 'delete'])->name('products.delete')->middleware(['permission:products-delete']);
    
    // All product pack route (not used)
    Route::get('/product-packs',           [ProductPackController::class, 'index'])->name('product-packs.index');
    Route::get('/product-packs/create',    [ProductPackController::class, 'create'])->name('product-packs.create');
    Route::post('/product-packs',          [ProductPackController::class, 'store'])->name('product-packs.store');
    Route::get('/product-packs/{id}',      [ProductPackController::class, 'show'])->name('product-packs.show');
    Route::get('/product-packs/{id}/edit', [ProductPackController::class, 'edit'])->name('product-packs.edit');
    Route::put('/product-packs/{id}',      [ProductPackController::class, 'update'])->name('product-packs.update');
    
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
    
    // All payment gateway route
    Route::get('/gateways/payment',           [PaymentGatewayController::class, 'index'])->name('payments.index')->middleware(['permission:payment-types-read']);
    Route::get('/gateways/payment/create',    [PaymentGatewayController::class, 'create'])->name('payments.create')->middleware(['permission:payment-types-create']);
    Route::post('/gateways/payment',          [PaymentGatewayController::class, 'store'])->name('payments.store')->middleware(['permission:payment-types-create']);
    Route::get('/gateways/payment/{id}',      [PaymentGatewayController::class, 'show'])->name('payments.show')->middleware(['permission:payment-types-read']);
    Route::get('/gateways/payment/{id}/edit', [PaymentGatewayController::class, 'edit'])->name('payments.edit')->middleware(['permission:payment-types-update']);
    Route::put('/gateways/payment/{id}',      [PaymentGatewayController::class, 'update'])->name('payments.update')->middleware(['permission:payment-types-update']);
    
    // All delivery gateway route
    Route::get('/gateways/delivery',           [DeliveryGatewayController::class, 'index'])->name('deliveries.index')->middleware(['permission:delivery-types-read']);
    Route::get('/gateways/delivery/create',    [DeliveryGatewayController::class, 'create'])->name('deliveries.create')->middleware(['permission:delivery-types-create']);
    Route::post('/gateways/delivery',          [DeliveryGatewayController::class, 'store'])->name('deliveries.store')->middleware(['permission:delivery-types-create']);
    Route::get('/gateways/delivery/{id}',      [DeliveryGatewayController::class, 'show'])->name('deliveries.show')->middleware(['permission:delivery-types-read']);
    Route::get('/gateways/delivery/{id}/edit', [DeliveryGatewayController::class, 'edit'])->name('deliveries.edit')->middleware(['permission:delivery-types-update']);
    Route::put('/gateways/delivery/{id}',      [DeliveryGatewayController::class, 'update'])->name('deliveries.update')->middleware(['permission:delivery-types-update']);
    
    // All coupon code route
    Route::get('/coupon-codes',           [CouponCodeController::class, 'index'])->name('coupon-codes.index')->middleware(['permission:coupon-codes-read']);
    Route::get('/coupon-codes/create',    [CouponCodeController::class, 'create'])->name('coupon-codes.create')->middleware(['permission:coupon-codes-create']);
    Route::post('/coupon-codes',          [CouponCodeController::class, 'store'])->name('coupon-codes.store')->middleware(['permission:coupon-codes-create']);
    Route::get('/coupon-codes/{id}',      [CouponCodeController::class, 'show'])->name('coupon-codes.show')->middleware(['permission:coupon-codes-read']);
    Route::get('/coupon-codes/{id}/edit', [CouponCodeController::class, 'edit'])->name('coupon-codes.edit')->middleware(['permission:coupon-codes-update']);
    Route::put('/coupon-codes/{id}',      [CouponCodeController::class, 'update'])->name('coupon-codes.update')->middleware(['permission:coupon-codes-update']);
    
    // All order status route
    Route::get('/order-statuses',           [OrderStatusController::class, 'index'])->name('order-statuses.index')->middleware(['permission:order-status-read']);
    Route::get('/order-statuses/create',    [OrderStatusController::class, 'create'])->name('order-statuses.create')->middleware(['permission:order-status-create']);
    Route::post('/order-statuses',          [OrderStatusController::class, 'store'])->name('order-statuses.store')->middleware(['permission:order-status-create']);
    Route::get('/order-statuses/{id}',      [OrderStatusController::class, 'show'])->name('order-statuses.show')->middleware(['permission:order-status-read']);
    Route::get('/order-statuses/{id}/edit', [OrderStatusController::class, 'edit'])->name('order-statuses.edit')->middleware(['permission:order-status-update']);
    Route::put('/order-statuses/{id}',      [OrderStatusController::class, 'update'])->name('order-statuses.update')->middleware(['permission:order-status-update']);
    
    // All role route
    Route::get('roles',           [RoleController::class, 'index'])->name('roles')->middleware(['permission:roles-read']);
    Route::get('roles/create',    [RoleController::class, 'create'])->name('roles.create')->middleware(['permission:roles-create']);
    Route::post('roles',          [RoleController::class, 'store'])->name('roles.store')->middleware(['permission:roles-create']);
    Route::get('roles/{id}',      [RoleController::class, 'show'])->name('roles.show')->middleware(['permission:roles-read']);
    Route::get('roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit')->middleware(['permission:roles-update']);
    Route::put('roles/{id}',      [RoleController::class, 'update'])->name('roles.update')->middleware(['permission:roles-update']);
    
    // All permission route
    Route::get('permissions',           [PermissionController::class, 'index'])->name('permissions')->middleware(['permission:permissions-read']);
    Route::get('permissions/create',    [PermissionController::class, 'create'])->name('permissions.create')->middleware(['permission:permissions-create']);
    Route::post('permissions',          [PermissionController::class, 'store'])->name('permissions.store')->middleware(['permission:permissions-create']);
    Route::get('permissions/{id}',      [PermissionController::class, 'show'])->name('permissions.show')->middleware(['permission:permissions-read']);
    Route::get('permissions/{id}/edit', [PermissionController::class, 'edit'])->name('permissions.edit')->middleware(['permission:permissions-update']);
    Route::put('permissions/{id}',      [PermissionController::class, 'update'])->name('permissions.update')->middleware(['permission:permissions-update']);
    
    // All offer route
    Route::get('offers/quantity',           [OfferController::class, 'index'])->name('offers.quantity.index')->middleware(['permission:offers-read']);
    Route::get('offers/quantity/create',    [OfferController::class, 'create'])->name('offers.quantity.create')->middleware(['permission:offers-create']);
    Route::post('offers/quantity',          [OfferController::class, 'store'])->name('offers.quantity.store')->middleware(['permission:offers-create']);
    Route::get('offers/quantity/{id}',      [OfferController::class, 'show'])->name('offers.quantity.show')->middleware(['permission:offers-read']);
    Route::get('offers/quantity/{id}/edit', [OfferController::class, 'edit'])->name('offers.quantity.edit')->middleware(['permission:offers-update']);
    Route::put('offers/quantity/{id}',      [OfferController::class, 'update'])->name('offers.quantity.update')->middleware(['permission:offers-update']);
    
    // All offer route
    Route::get('offers/bsgs',           [BSGSOfferController::class, 'index'])->name('offers.bsgs.index')->middleware(['permission:offers-read']);
    Route::get('offers/bsgs/create',    [BSGSOfferController::class, 'create'])->name('offers.bsgs.create')->middleware(['permission:offers-create']);
    Route::post('offers/bsgs',          [BSGSOfferController::class, 'store'])->name('offers.bsgs.store')->middleware(['permission:offers-create']);
    Route::get('offers/bsgs/{id}',      [BSGSOfferController::class, 'show'])->name('offers.bsgs.show')->middleware(['permission:offers-read']);
    Route::get('offers/bsgs/{id}/edit', [BSGSOfferController::class, 'edit'])->name('offers.bsgs.edit')->middleware(['permission:offers-update']);
    Route::put('offers/bsgs/{id}',      [BSGSOfferController::class, 'update'])->name('offers.bsgs.update')->middleware(['permission:offers-update']);
    
    // Medical device banner (not used)
    Route::get('medical/device/banners',           [MedicalBannerController::class, 'index'])->name('medical.device.banners');
    Route::get('medical/device/banners/create',    [MedicalBannerController::class, 'create'])->name('medical.device.banners.create');
    Route::post('medical/device/banners',          [MedicalBannerController::class, 'store'])->name('medical.device.banners.store');
    Route::get('medical/device/banners/{id}',      [MedicalBannerController::class, 'show'])->name('medical.device.banners.show');
    Route::get('medical/device/banners/{id}/edit', [MedicalBannerController::class, 'edit'])->name('medical.device.banners.edit');
    Route::put('medical/device/banners/{id}',      [MedicalBannerController::class, 'update'])->name('medical.device.banners.update');
    
    // Brand banner (not used)
    Route::get('brand/banners',           [BrandBannerController::class, 'index'])->name('brand.banners');
    Route::get('brand/banners/create',    [BrandBannerController::class, 'create'])->name('brand.banners.create');
    Route::post('brand/banners',          [BrandBannerController::class, 'store'])->name('brand.banners.store');
    Route::get('brand/banners/{id}',      [BrandBannerController::class, 'show'])->name('brand.banners.show');
    Route::get('brand/banners/{id}/edit', [BrandBannerController::class, 'edit'])->name('brand.banners.edit');
    Route::put('brand/banners/{id}',      [BrandBannerController::class, 'update'])->name('brand.banners.update');
    
    // Banner route
    Route::get('banners',           [BannerController::class, 'index'])->name('banners')->middleware(['permission:banners-read']);
    Route::get('banners/create',    [BannerController::class, 'create'])->name('banners.create')->middleware(['permission:banners-create']);
    Route::post('banners',          [BannerController::class, 'store'])->name('banners.store')->middleware(['permission:banners-create']);
    Route::get('banners/{id}',      [BannerController::class, 'show'])->name('banners.show')->middleware(['permission:banners-read']);
    Route::get('banners/{id}/edit', [BannerController::class, 'edit'])->name('banners.edit')->middleware(['permission:banners-update']);
    Route::put('banners/{id}',      [BannerController::class, 'update'])->name('banners.update')->middleware(['permission:banners-update']);
    
    // Attribute route
    Route::get('families',           [FamilyController::class, 'index'])->name('families')->middleware(['permission:families-read']);
    Route::get('families/create',    [FamilyController::class, 'create'])->name('families.create')->middleware(['permission:families-create']);
    Route::post('families',          [FamilyController::class, 'store'])->name('families.store')->middleware(['permission:families-create']);
    Route::get('families/{id}',      [FamilyController::class, 'show'])->name('families.show')->middleware(['permission:families-read']);
    Route::get('families/{id}/edit', [FamilyController::class, 'edit'])->name('families.edit')->middleware(['permission:families-update']);
    Route::put('families/{id}',      [FamilyController::class, 'update'])->name('families.update')->middleware(['permission:families-update']);

    // Section route
    Route::get('sections',           [SectionController::class, 'index'])->name('sections.index')->middleware(['permission:sections-read']);
    Route::get('sections/create',    [SectionController::class, 'create'])->name('sections.create')->middleware(['permission:sections-create']);
    Route::post('sections',          [SectionController::class, 'store'])->name('sections.store')->middleware(['permission:sections-create']);
    Route::get('sections/{id}',      [SectionController::class, 'show'])->name('sections.show')->middleware(['permission:sections-read']);
    Route::get('sections/{id}/edit', [SectionController::class, 'edit'])->name('sections.edit')->middleware(['permission:sections-update']);
    Route::put('sections/{id}',      [SectionController::class, 'update'])->name('sections.update')->middleware(['permission:sections-update']);

    // user route
    Route::get('users',           [UserController::class, 'index'])->name('users.index')->middleware(['permission:users-read']);
    Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware(['permission:users-update']);
    Route::put('users/{id}',      [UserController::class, 'update'])->name('users.update')->middleware(['permission:users-update']);
    Route::get('users/create',    [UserController::class, 'userCreate'])->name('users.registration.create')->middleware(['permission:users-create']);
    Route::post('users/create',   [UserController::class, 'userStore'])->name('users.registration.store')->middleware(['permission:users-create']);

    // App contrller route (not used)
    Route::get('app/update/view', [AppController::class, 'updateView'])->name('app.update.view')->middleware(['permission:app-version-update']);
    Route::get('app/update',      [AppController::class, 'update'])->name('app.update')->middleware(['permission:app-version-update']);

    // Price logs route
    Route::get('products/price/logs', [ProductPriceLogController::class, 'index'])->name('logs.index')->middleware(['permission:price-log-read']);

    // Purchase order route
    Route::get('purchase/orders', [PurchaseOrderController::class, 'index'])->name('purchase.orders.index')->middleware(['permission:purchase-order-read']);
    Route::get('purchase/orders/create', [PurchaseOrderController::class, 'create'])->name('purchase.orders.create')->middleware(['permission:purchase-order-create']);
    Route::post('purchase/orders', [PurchaseOrderController::class, 'store'])->name('purchase.orders.store')->middleware(['permission:purchase-order-create']);

    // Sell partners route
    Route::get('sell-partners',           [SellPartnerController::class, 'index'])->name('sell-partners.index')->middleware(['permission:sell-partners-read']);
    Route::get('sell-partners/create',    [SellPartnerController::class, 'create'])->name('sell-partners.create')->middleware(['permission:purchase-order-create']);
    Route::post('sell-partners',          [SellPartnerController::class, 'store'])->name('sell-partners.store')->middleware(['permission:purchase-order-create']);
    Route::get('sell-partners/{id}',      [SellPartnerController::class, 'show'])->name('sell-partners.show')->middleware(['permission:purchase-order-read']);
    Route::get('sell-partners/{id}/edit', [SellPartnerController::class, 'edit'])->name('sell-partners.edit')->middleware(['permission:purchase-order-update']);
    Route::put('sell-partners/{id}',      [SellPartnerController::class, 'update'])->name('sell-partners.update')->middleware(['permission:purchase-order-update']);
});
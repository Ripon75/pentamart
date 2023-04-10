<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\AuthController;
use App\Http\Controllers\Front\PageController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\OrderController;
use App\Http\Controllers\Front\CouponController;
use App\Http\Controllers\Front\AddressController;
use App\Http\Controllers\Front\CustomerController;
use App\Http\Controllers\Front\WishlistController;

use Illuminate\Support\Facades\Http;

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

Route:: get('/',                     [PageController::class, 'home'])->name('home');
Route:: get('/about',                [PageController::class, 'about'])->name('about');
Route:: get('/not-found',            [PageController::class, 'notFound'])->name('notFound');
Route:: get('/terms-and-conditions', [PageController::class, 'termsAndConditions'])->name('terms-and-conditions');
Route:: get('/frequently-asked-questions', [PageController::class, 'frequentlyAskedQuestions'])->name('frequently-asked-questions');
Route:: get('/promotion-offers', [PageController::class, 'promotionOffers'])->name('promotion-offers');
Route:: get('/privacy-policy',   [PageController::class, 'privacyPolicy'])->name('privacy-policy');
Route:: get('/return-policy',    [PageController::class, 'returnPolicy'])->name('return-policy');
Route:: get('/contact',          [PageController::class, 'contact'])->name('contact');
Route:: get('/brand/{slug}',     [PageController::class, 'brand'])->name('brands.show');
Route:: get('/generic/{slug}/{thumbOnly?}',     [PageController::class, 'generic'])->name('generics.show');
Route:: get('/dosage-form/{slug}/{thumbOnly?}', [PageController::class, 'dosageForm'])->name('dosage-forms.show');
Route:: get('/company/{slug}/{thumbOnly?}',     [PageController::class, 'company'])->name('companies.show');
Route:: get('/products/{thumbOnly?}',           [PageController::class, 'index'])->name('products.index');
Route:: get('/products/{id}/{slug?}',           [PageController::class, 'productShow'])->name('products.show');
Route:: get('/offers/categories/{slug}/{thumbOnly?}', [PageController::class, 'offerCategoryProduct'])->name('offers.categories.products');
Route:: get('/offers/{thumbOnly?}', [PageController::class, 'offerProduct'])->name('offers.products');

// Registration route
Route::get('/signup',  [AuthController::class, 'registrationCreate'])->name('signup');
Route::post('/signup', [AuthController::class, 'registrationStore'])->name('signup.store');

// Login route
Route::get('/login',     [AuthController::class, 'loginCreate'])->name('login');
Route::post('/login',    [AuthController::class, 'newLoginStore'])->name('new-login.store');
Route::post('/send/otp', [AuthController::class, 'sendotp'])->name('send.otp');
// Password recovery route
Route::get('/password/recover',                  [AuthController::class, 'recover'])->name('password.recover');
Route::post('/password/recover/email-or-phone',  [AuthController::class, 'emailOrPhoneStore']);
Route::post('/password/recover/send-code',       [AuthController::class, 'codeCheck']);
Route::get('/password/recover/resend-code',      [AuthController::class, 'resendCode']);
Route::post('/password/recover/update-password', [AuthController::class, 'passwordUpdate']);
// Phone activation route
Route::get('/phone/activation/send-code',                [AuthController::class, 'sendActivatonCode']);
Route::get('/phone/activation/code-check/{phoneNumber}', [AuthController::class, 'phoneActivationcodeView'])->name('phone.active.code.check.view');
Route::post('/phone/activation/code-check',              [AuthController::class, 'phoneActivationcodeCheck'])->name('phone.active.code.check');
Route::get('/phone/activation/resend-code',              [AuthController::class, 'phoneActivationResendCode']);

// Socialite
Route::get('/auth/social/redirect/{service}', [AuthController::class, 'socialRedirect'])->name('social.login');
Route::get('/auth/social/callback/{service}', [AuthController::class, 'socialCallback'])->name('social.callback');
// Cart items and wishlist count route
Route::get('/cart/count', [CartController::class, 'cartItemCount']);
// Personal care route
// Route::get('tags/{slug}/{thumbOnly?}',       [PageController::class, 'tagPage'])->name('tag.page');
Route::get('categories/{slug}/{thumbOnly?}', [PageController::class, 'categoryPage'])->name('category.page');
// Route::get('symptoms/{slug}/{thumbOnly?}',   [PageController::class, 'symptomPage'])->name('symptom.page');
Route::get('brands/{slug}/{thumbOnly?}',     [PageController::class, 'brandPage'])->name('brand.page');
// Get area
Route::get('area/{name}', [AddressController::class, 'getArea'])->name('area.single');

// Check auth
Route::middleware(['auth'])->group(function(){
    // All Cart route
    Route::get('/checkout',                   [PageController::class, 'checkout'])->name('checkout');
    Route::post('/cart/item/add',             [CartController::class, 'addItem'])->name('cart.item.add');
    Route::post('/cart/item/remove',          [CartController::class, 'removeItem'])->name('cart.item.remove');
    Route::get('/cart/empty',                 [CartController::class, 'emptyCart']);
    Route::post('/cart/meta/add',             [CartController::class, 'addMetaData']);
    Route::post('/cart/shipping/address/add', [CartController::class, 'addShippingAdress']);
    Route::get('/upload/prescription',        [CartController::class, 'uploadPrescription'])->name('upload.prescription');
    Route::post('/upload/prescription',       [CartController::class, 'prescriptionStore'])->name('prescription.store');
    Route::get('/show/prescription/{id}',     [CartController::class, 'showPrescription'])->name('show.prescription');
    Route::post('/check/coupon',              [CouponController::class, 'checkCouponCode'])->name('coupon.check');
    Route::get('/drawer/cart',                [CartController::class, 'drawerCart']);

    Route::prefix('my')->name('my.')
    ->group(function () {
        // User profile update route
        Route::get('/dashboard', [OrderController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile',   [CustomerController::class, 'profileEdit'])->name('profile');
        Route::put('/profile',   [CustomerController::class, 'profileUpdate'])->name('profile.update');
        // User password update route
        Route::get('/password', [CustomerController::class, 'passwordEdit'])->name('password');
        Route::put('/password', [CustomerController::class, 'passwordUpdate'])->name('password.update');
        // User address route
        Route::get('/address',           [AddressController::class, 'index'])->name('address.index');
        Route::get('/address/create',    [AddressController::class, 'create'])->name('address.create');
        Route::post('/address',          [AddressController::class, 'store'])->name('address.store');
        Route::post('/address/others',   [AddressController::class, 'otherStore'])->name('address.other.store');
        Route::get('/address/{id}/edit', [AddressController::class, 'edit'])->name('address.edit');
        Route::put('/address/{id}',      [AddressController::class, 'update'])->name('address.update');
        Route::get('/address/{id}',      [AddressController::class, 'destroy'])->name('address.destroy');
        Route::get('/shipping/addrss',   [AddressController::class, 'shippingAddress'])->name('single.address');
        // Wishlist route
        Route::get('/wishlist',         [WishlistController::class, 'index'])->name('wishlist');
        Route::post('/wishlist',        [WishlistController::class, 'store'])->name('wishlist.store');
        Route::get('/wishlist/undo',    [WishlistController::class, 'undo'])->name('wishlist.undo');
        Route::post('/wishlist/remove', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
        // Order route
        Route::post('/order',            [OrderController::class, 'store'])->name('order.store');
        Route::get('/order',             [OrderController::class, 'index'])->name('order');
        Route::post('/order/remove',     [OrderController::class, 'removeItem'])->name('order.remove');
        Route::get('/order/suceess',     [OrderController::class, 'orderSuccess'])->name('order.success');
        Route::get('/order/failed',      [OrderController::class, 'orderFailed'])->name('order.failed');
        Route::get('/order/{id}',        [OrderController::class, 'show'])->name('order.show');
        Route::get('/reorder/{orderID}', [OrderController::class, 'reorder'])->name('order.reorder');
        Route::any('/order/payment/{orderID}', [OrderController::class, 'makePayment'])->name('order.payment');
        Route::get('/latest/delivered/order', [OrderController::class, 'latestDeliveredOrder'])->name('latest.delivered.order');
        Route::post('/latest/delivered/order/{id}', [OrderController::class, 'latestDeliveredOrderUpdate'])->name('latest.delivered.order.update');
    });

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

// ========<Frontend page Routing>=============

Route::get('/design/components', function () {
    return view('components');
});

// ======== </Frontend page Routing>=============

Route::get('/user-order-info', [CustomerController::class, 'userOrderInfo']);

Route::get('/meilisearch/make/unsearchable', function() {
    Product::where('status', 'inactivated')->unsearchable();
});


// TEST Route ===========================
Route::get('/test',function() {
});

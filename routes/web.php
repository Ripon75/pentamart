<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\AuthController;
use App\Http\Controllers\Front\PageController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\OrderController;
use App\Http\Controllers\Front\CouponController;
use App\Http\Controllers\Front\AddressController;
use App\Http\Controllers\Front\CustomerController;
use App\Http\Controllers\Front\RatingController;
use App\Http\Controllers\Front\WishlistController;

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

Route:: get('/',               [PageController::class, 'home'])->name('home');
Route:: get('/about',          [PageController::class, 'about'])->name('about');
Route:: get('/privacy-policy', [PageController::class, 'privacyPolicy'])->name('privacy.policy');
Route:: get('/return-policy',  [PageController::class, 'returnPolicy'])->name('return.policy');
Route:: get('/contact',        [PageController::class, 'contact'])->name('contact');
Route:: get('/products',       [PageController::class, 'index'])->name('products.index');
Route:: get('/offers',         [PageController::class, 'offerProduct'])->name('offers.products');
Route:: get('/terms-and-conditions',     [PageController::class, 'termsAndConditions'])->name('terms.and.condition');
Route:: get('/products/{id}/{slug?}',    [PageController::class, 'productShow'])->name('products.show');
Route:: get('/offers/categories/{slug}', [PageController::class, 'offerCategoryProduct'])->name('offers.categories.products');

// Registration route
Route::get('/registration',  [AuthController::class, 'registrationCreate'])->name('registration');
Route::post('/registration', [AuthController::class, 'registrationStore'])->name('registration.store');

// Login route
Route::get('/login',           [AuthController::class, 'loginCreate'])->name('login.create');
Route::post('/login',          [AuthController::class, 'login'])->name('login');
Route::post('/check-user',     [AuthController::class, 'checkUser'])->name('check.user');
Route::get('/send-otp-code',   [AuthController::class, 'sendOtp'])->name('send.otp');
Route::get('/resend-otp-code', [AuthController::class, 'resendOtpCode']);

// Socialite
Route::get('/auth/social/redirect/{service}', [AuthController::class, 'socialRedirect'])->name('social.login');
Route::get('/auth/social/callback/{service}', [AuthController::class, 'socialCallback'])->name('social.callback');

// Brand and category page
Route::get('categories/{id}/{slug?}', [PageController::class, 'categoryPage'])->name('category.page');
Route::get('brands/{id}/{slug?}',     [PageController::class, 'brandPage'])->name('brand.page');

// Get single area
Route::get('area/{name}', [AddressController::class, 'getArea'])->name('area.single');

// Check auth
Route::middleware(['auth'])->group(function(){
    // All Cart route
    Route::get('/cart/items',         [CartController::class, 'cartItem'])->name('cart.items');
    Route::get('/checkout',           [CartController::class, 'checkout'])->name('checkout');
    Route::post('/cart/items/add',    [CartController::class, 'addItem'])->name('cart.item.add');
    Route::post('/cart/items/remove', [CartController::class, 'removeItem'])->name('cart.item.remove');
    Route::get('/cart/items/count',   [CartController::class, 'cartItemCount']);
    Route::get('/cart/items/empty',   [CartController::class, 'emptyCart']);
    Route::post('/cart/meta/add',     [CartController::class, 'addMetaData']);
    Route::post('/check/coupon',      [CouponController::class, 'checkCouponCode'])->name('coupon.check');
    Route::post('/cart/shipping/add', [CartController::class, 'addShippingAdress']);

    Route::prefix('my')->name('my.')->group(function () {
        // User profile update route
        Route::get('/dashboard', [OrderController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile',   [CustomerController::class, 'profileEdit'])->name('profile');
        Route::put('/profile',   [CustomerController::class, 'profileUpdate'])->name('profile.update');

        // User address route
        Route::get('/address',           [AddressController::class, 'index'])->name('address');
        Route::get('/address/create',    [AddressController::class, 'create'])->name('address.create');
        Route::post('/address',          [AddressController::class, 'store'])->name('address.store');
        Route::get('/address/{id}/edit', [AddressController::class, 'edit'])->name('address.edit');
        Route::put('/address/{id}',      [AddressController::class, 'update'])->name('address.update');
        Route::get('/shipping/addrss',   [AddressController::class, 'shippingAddress'])->name('single.address');

        // Wishlist route
        Route::get('/wishlist',         [WishlistController::class, 'index'])->name('wishlist');
        Route::post('/wishlist',        [WishlistController::class, 'store'])->name('wishlist.store');
        Route::get('/wishlist/undo',    [WishlistController::class, 'undo'])->name('wishlist.undo');
        Route::post('/wishlist/remove', [WishlistController::class, 'destroy'])->name('wishlist.destroy');

        // Order route
        Route::post('/order',        [OrderController::class, 'store'])->name('order.store');
        Route::get('/order',         [OrderController::class, 'index'])->name('order');
        Route::post('/order/remove', [OrderController::class, 'removeItem'])->name('order.remove');
        Route::get('/order/suceess', [OrderController::class, 'orderSuccess'])->name('order.success');
        Route::get('/order/failed',  [OrderController::class, 'orderFailed'])->name('order.failed');
        Route::get('/order/{id}',    [OrderController::class, 'show'])->name('order.show');
    });

    // Rating route
    Route::post('/ratings', [RatingController::class, 'store'])->name('ratings.store');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

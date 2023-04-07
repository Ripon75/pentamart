<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Front\OrderController;
use App\Http\Controllers\Api\AppVersionController;

Route::get('/product/search', [SearchController::class, 'productSearch']);
Route::get('/user/search',    [SearchController::class, 'userSearch']);
Route::get('/user/address',   [SearchController::class, 'userAddress']);
// App version controll route
Route::get('/current/version', [AppVersionController::class, 'currnetVersion']);
Route::get('/next/version',   [AppVersionController::class, 'nextVersion']);
// Offer quantity route
Route::get('/check/offer/quantity', [SearchController::class, 'checkOfferQty']);
// Order create api
Route::post('/orders/create', [OrderController::class, 'orderCreate']);
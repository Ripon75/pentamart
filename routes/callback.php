<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\CallbackController;


Route::match(['get', 'post'], '/payment/{gateway}/{type?}', [CallbackController::class, 'callback'])->name('payment_gateway');

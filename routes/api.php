<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SearchController;

Route::get('/product/search', [SearchController::class, 'productSearch']);
Route::get('/user/search',    [SearchController::class, 'userSearch']);
Route::get('/address/search', [SearchController::class, 'addressSearch']);

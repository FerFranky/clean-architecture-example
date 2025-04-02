<?php

use App\Presentation\Http\Controllers\OrderController;
use App\Presentation\Http\Controllers\OrderStatusController;
use Illuminate\Support\Facades\Route;


Route::apiResource('/orders', OrderController::class);
Route::get('/orders/{status}/status', [OrderStatusController::class, 'index']);

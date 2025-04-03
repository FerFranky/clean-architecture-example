<?php

use App\Presentation\Http\Controllers\Order\OrderController;
use App\Presentation\Http\Controllers\Order\OrderStatusController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/orders', OrderController::class);
Route::get('/orders/{status}/status', [OrderStatusController::class, 'index']);
Route::patch('/orders/{status}/status', [OrderStatusController::class, 'patch']);

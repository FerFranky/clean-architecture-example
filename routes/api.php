<?php

use App\Presentation\Http\Controllers\Order\OrderController;
use App\Presentation\Http\Controllers\Order\OrderStatusController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/orders', OrderController::class)->names('orders');
Route::get('/orders/{status}/status', [OrderStatusController::class, 'index'])->name('orders.status.index');
Route::patch('/orders/{id}/status', [OrderStatusController::class, 'patch'])->name('orders.status.patch');

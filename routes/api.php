<?php

use App\Presentation\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;


Route::post('/orders', [OrderController::class, 'store']);

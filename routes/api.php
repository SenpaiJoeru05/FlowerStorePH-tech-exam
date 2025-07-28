<?php
// filepath: d:\My Works\flowerstoreph-tech-exam\routes\api.php
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

Route::apiResource('products', ProductController::class);
Route::apiResource('orders', OrderController::class);
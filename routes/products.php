<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VariantController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {

});

Route::middleware('auth')->group(function () {

    Route::resources([
        'group' => GroupController::class,
        'variant' => VariantController::class,
        'product' => ProductController::class,
        'invoice' => InvoiceController::class,
    ]);
});

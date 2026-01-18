<?php

use App\Http\Controllers\ShippingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('shippings');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('shippings', [ShippingController::class, 'index'])->name('shippings');
    Route::get('shippings/create', [ShippingController::class, 'create'])->name('shippings.create');
    Route::post('shippings', [ShippingController::class, 'store'])->name('shippings.store');
});

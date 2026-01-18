<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return redirect()->route('shippings');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('shippings', function () {
        return Inertia::render('shippings/shippings');
    })->name('shippings');
});

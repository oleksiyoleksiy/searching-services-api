<?php

use App\Http\Controllers\Provider\BookingController;
use App\Http\Controllers\Provider\ReviewController;
use App\Http\Controllers\Provider\ServiceController;
use App\Models\Service;
use Illuminate\Support\Facades\Route;

Route::get('review', [ReviewController::class, 'index'])->name('review.index');

Route::group(['controller' => ServiceController::class, 'prefix' => 'service', 'as' => 'service.'], function () {
    Route::get('', 'index')->name('index');
    Route::post('', 'store')->name('store');
    Route::delete('{service}', 'destroy')->name('destroy');
    Route::put('{service}', 'update')->name('update');
});

Route::group(['controller' => BookingController::class, 'prefix' => 'booking', 'as' => 'booking.'], function () {
    Route::get('', 'index')->name('index');
    Route::post('{booking}/{status}', 'changeStatus')->name('change-status');
});

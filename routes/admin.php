<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\StatsController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/stats', [StatsController::class, 'index'])->name('stats.index');

Route::group(['prefix' => 'user', 'controller' => UserController::class, 'as' => 'user.'], function () {
    Route::get('', 'index')->name('index');
    Route::get('{user}', 'show')->name('show');
    Route::post('', 'store')->name('store');
    Route::post('{user}', 'update')->name('update');
});

Route::group(['prefix' => 'service', 'controller' => ServiceController::class, 'as' => 'service.'], function () {
    Route::get('', 'index')->name('index');
    Route::post('', 'store')->name('store');
    Route::put('{user}', 'update')->name('update');
    Route::delete('{user}', 'destroy')->name('destroy');
});

Route::group(['prefix' => 'review', 'controller' => ReviewController::class, 'as' => 'review.'], function () {
    Route::get('', 'index')->name('index');
    Route::delete('{review}', 'destroy')->name('destroy');
});

Route::group(['prefix' => 'category', 'controller' => CategoryController::class, 'as' => 'category.'], function () {
    Route::get('', 'index')->name('index');
    Route::post('', 'store')->name('store');
    Route::put('{category}', 'update')->name('update');
    Route::delete('{category}', 'destroy')->name('destroy');
});

<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'user', 'controller' => UserController::class, 'as' => 'user.'], function () {
    Route::get('', 'index')->name('index');
    Route::get('{user}', 'show')->name('show');
    Route::post('', 'store')->name('store');
    Route::post('{user}', 'update')->name('update');
});

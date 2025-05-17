<?php

use App\Enums\TokenAbility;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryProviderController;
use App\Http\Controllers\CompanyAvailabilityController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('guest:sanctum')->controller(AuthController::class)->group(
    function () {
        Route::post('/login', 'login');
        Route::post('/register', 'register');
    }
);

Route::post('/refresh', [AuthController::class, 'refresh'])
    ->middleware(['auth:sanctum', 'ability:' . TokenAbility::ISSUE_ACCESS_TOKEN->value]);

Route::get('/category/{category}/provider', [CategoryProviderController::class, 'index']);
Route::get('/provider', [ProviderController::class, 'index']);
Route::get('/provider/{company}', [ProviderController::class, 'show'])->middleware('optional-auth');
Route::apiResource('category', CategoryController::class);

Route::middleware(['auth:sanctum', 'ability:' . TokenAbility::ACCESS_API->value])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::group(['controller' => UserController::class, 'prefix' => 'user'], function () {
        Route::get('', 'current');
        Route::post('update', 'update');
    });
    Route::group(['controller' => FavoriteController::class, 'prefix' => 'favorite'], function () {
        Route::get('', 'index');
        Route::post('{company}', 'store');
    });
    Route::group(['controller' => BookingController::class, 'prefix' => 'booking'], function () {
        Route::get('', 'index');
        Route::post('{service}', 'store');
        Route::post('{booking}/cancel', 'cancel');
    });
    Route::post('/provider/update', [ProviderController::class, 'update']);
    Route::get('/service/{company}', [ServiceController::class, 'index']);
    Route::get('/availability/{company}', [CompanyAvailabilityController::class, 'index']);
    Route::post('/review/{company}', [ReviewController::class, 'store']);
    Route::prefix('admin')->group(function () {});
});

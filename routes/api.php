<?php

use App\Enums\TokenAbility;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProviderController;
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

Route::get('/category/{category}/provider', [ProviderController::class, 'index']);
Route::apiResource('category', CategoryController::class);

Route::middleware(['auth:sanctum', 'ability:' . TokenAbility::ACCESS_API->value])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [UserController::class, 'current']);
    Route::post('/user/update', [UserController::class, 'update']);
    Route::post('/provider/update', [ProviderController::class, 'update']);
    Route::prefix('admin')->group(function () {

    });
});

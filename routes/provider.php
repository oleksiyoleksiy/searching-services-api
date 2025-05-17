<?php

use App\Http\Controllers\Provider\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('review', [ReviewController::class, 'index'])->name('review.index');

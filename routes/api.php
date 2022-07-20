<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\PassportController;

Route::post('register', [PassportController::class, 'register']);
Route::post('login', [PassportController::class, 'login']);

//put all api protected routes here
Route::middleware('auth:api')->group(function () {
    Route::get('users', [PassportController::class, 'users']);
    Route::post('logout', [PassportController::class, 'logout']);
    Route::post('profile/update', [PassportController::class, 'updateProfile']);
    Route::post('stripe', [StripeController::class, 'stripePost']);
});

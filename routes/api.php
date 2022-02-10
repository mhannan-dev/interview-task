<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\RegisterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Route::post('apiLogin', [RegisterController::class, 'apiLogin']);
// Route::middleware('auth:api')->group(function () {
//     Route::get('profile/{id}',  [CustomerController::class, 'profile'])->name('profile');
// });

//Public routes
Route::group(['middleware' => ['cors', 'json.response']], function () {
    Route::post('login', [AuthController::class, 'apiLogin'])->name('login.api');
    Route::get('details/{id}', [AuthController::class, 'customerDetails'])->name('customerDetails');
    Route::post('logout/{id}', [AuthController::class, 'logout'])->name('logout.api');
});

<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Admin\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//To clear all cache
Route::get('cc', function () {
    // Artisan::call('cache:clear');
    // Artisan::call('config:clear');
    // Artisan::call('config:cache');
    // Artisan::call('view:clear');
    //Artisan::call('route:cache');
    Artisan::call('optimize:clear');
    return "Cleared!";
});


Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->namespace('Admin')->group(function () {
	Route::match(['get', 'post'], '/', [AdminController::class, 'login']);
	Route::group(['middleware' => ['admin']], function () {
		Route::get('dashboard', [AdminController::class, 'dashboard']);
		Route::get('settings', [AdminController::class, 'settings']);
		Route::post('check-current-pwd', [AdminController::class, 'check_current_pwd']);
		Route::post('update-current-pwd', [AdminController::class, 'update_current_pwd']);
		Route::match(['get', 'post'], '/profile-update', [AdminController::class, 'profile_update']);
		Route::get('other-setting', [AdminController::class, 'otherSetting']);
		Route::match(['get', 'post'], '/add-edit-other-setting/{id?}', [AdminController::class, 'addEditOtherSetting']);
		Route::get('logout',  [AdminController::class, 'logout']);
	});
});

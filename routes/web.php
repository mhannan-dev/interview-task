<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\EmployeeController;

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
		Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
		Route::get('logout',  [AdminController::class, 'logout']);
        Route::match(['get', 'post'], 'add-edit-employee/{id?}', [EmployeeController::class, 'addEditEmployee'])->name('addEditEmployee');
        Route::get('all-employee',  [EmployeeController::class, 'employees'])->name('employees');
        Route::get('all-customer',  [CustomerController::class, 'customers'])->name('customers');
	});
});


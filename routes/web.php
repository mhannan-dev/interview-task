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
        Route::match(['get', 'post'], 'check-emp-email', [EmployeeController::class, 'checkEmpEmail']);
        Route::match(['get', 'post'], 'check-emp-phone', [EmployeeController::class, 'checkEmpPhone']);
        Route::get('all-customer',  [CustomerController::class, 'customers'])->name('customers');
        Route::match(['get', 'post'], 'check-customer-email', [CustomerController::class, 'checkEmail']);
        Route::match(['get', 'post'], 'check-phone', [CustomerController::class, 'checkPhone']);
        Route::get('search',  [CustomerController::class, 'liveSearch'])->name('live_search');
        Route::match(['get', 'post'], 'add-edit-customer/{id?}', [CustomerController::class, 'addEditCustomer'])->name('addEditCustomer');
        Route::post('csv-import', [CustomerController::class, 'uploadContent'])->name('csvUpload');
	});
});


<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/', [AuthController::class, 'auth'])->name('login.auth');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('auth')->group(function () {

    Route::prefix('/dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard.index');
    });

    Route::prefix('/customers')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])
            ->name('customers.index');

        Route::post('/store', [CustomerController::class, 'store'])
            ->name('customers.store');
    });

    Route::prefix('/sales')->group(function () {
        Route::get('/', [SaleController::class, 'index'])
            ->name('sales.index');

        Route::get('/create', [SaleController::class, 'create'])
            ->name('sales.create');

        Route::post('/store', [SaleController::class, 'store'])
            ->name('sales.store');

        Route::get('/destroy/{saleId}', [SaleController::class, 'destroy'])
            ->name('sales.destroy');
    });
});

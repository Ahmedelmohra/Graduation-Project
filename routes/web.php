<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\CompaniesController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/charge_wallet', [WalletController::class, 'update'])->name('charge_wallet');
Route::post('/login', [AuthController::class, 'login'])->name('login');

// get route request
Route::get('/clients/payments', [ClientsController::class, 'payments']);
Route::get('/companies_service', [CompaniesController::class, 'findByService']);

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\clientsController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\CompanyReciptsController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\ClientReciptsController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\RechargeController;

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
//CLIENTS
Route::get('/clients', [clientsController::class, 'index']);
Route::get('/clients/{id}', [clientsController::class, 'show']);
Route::post('/clients', [clientsController::class, 'store']);
Route::post('/clients/{id}', [clientsController::class, 'update']);
Route::get('/clients/{id}/payments', [clientsController::class, 'payments']);

//PAYMENT
Route::get('/payments', [PaymentsController::class, 'index']);
Route::get('/payments/{id}', [PaymentsController::class, 'show']);
Route::post('/payments', [PaymentsController::class, 'store']);  

//OTP
Route::get('/otp', [OtpController::class, 'index']);
Route::get('/otp/{id}', [OtpController::class, 'show']);
Route::post('/otp', [OtpController::class, 'store']);  

//CLIENT RECIPTS
Route::get('/clrecipts', [ClientReciptsController::class, 'index']);
Route::get('/clrecipts/{id}', [ClientReciptsController::class, 'show']);
Route::post('/clrecipts', [ClientReciptsController::class, 'store']);  

//COMPANY
Route::get('/comp', [CompaniesController::class, 'index']);
Route::get('/comp/{id}', [CompaniesController::class, 'show']);
Route::post('/comp', [CompaniesController::class, 'store']); 

//COMPANY RECIPTS
Route::get('/comrecipts', [CompanyReciptsController::class, 'index']);
Route::get('/comrecipts/{id}', [CompanyReciptsController::class, 'show']);
Route::post('/comrecipts', [CompanyReciptsController::class, 'store']); 


//WALLET
Route::get('/wallet', [WalletController::class, 'index']);
Route::get('/wallet/{id}', [WalletController::class, 'show']);
Route::post('/wallet', [WalletController::class, 'store']); 


//RECHARGE INFO
Route::get('/recharge', [RechargeController::class, 'index']);
Route::get('/recharge/{id}', [RechargeController::class, 'show']);
Route::post('/recharge', [RechargeController::class, 'store']); 















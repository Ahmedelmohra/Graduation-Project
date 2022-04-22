<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\walletController;
use App\Http\Controllers\RechargeController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ReciptsController;

use App\Http\Controllers\AuthController;


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
Route::post('/test' , [TestController::class , 'store'])->name('test.store');

//CLIENTS
Route::get('/clients', [ClientsController::class, 'index']);
Route::get('/clients/{id}', [ClientsController::class, 'show']);
Route::post('/clients', [ClientsController::class, 'store']);
Route::post('/clients/{id}', [ClientsController::class, 'update']);
Route::get('/destroy_clients', [ClientsController::class, 'destroy']);
Route::get('/clients/payments', [ClientsController::class, 'payments']);
Route::get('/clients/{id}/wallet', [ClientsController::class, 'wallet']);


//PAYMENT
Route::get('/payments', [PaymentsController::class, 'index']);
Route::get('/payments/{id}', [PaymentsController::class, 'show']);
Route::post('/payments', [PaymentsController::class, 'store']);  


//OTP
Route::get('/otps', [OtpController::class, 'index']);
Route::get('/otps/{id}', [OtpController::class, 'show']);
Route::post('/otps', [OtpController::class, 'store']); 
Route::post('/checkOtp', [OtpController::class, 'check']);
Route::post('/resend', [OtpController::class, 'resend']);


//RECIPTS
Route::get('/recipts', [ReciptsController::class, 'index']);
Route::get('/recipts/{id}', [ReciptsController::class, 'show']);
Route::post('/recipts', [ReciptsController::class, 'store']);  


//COMPANY
Route::get('/companies', [CompaniesController::class, 'index']);
Route::get('/companies/{id}', [CompaniesController::class, 'show']);
Route::get('/companies/{id}/payments', [CompaniesController::class, 'payments']);
Route::get('/companies/{service}', [CompaniesController::class, 'findByService']);


//WALLET
Route::get('/wallets', [walletController::class, 'index']);
Route::get('/wallets/{id}', [walletController::class, 'show']);
Route::post('/wallets', [walletController::class, 'store']);
Route::post('/clients/pay', [walletController::class, 'payWithWallet']);


//RECHARGE INFO
Route::get('/recharge', [RechargeController::class, 'index']);
Route::get('/recharge/{id}', [RechargeController::class, 'show']);
Route::post('/recharge', [RechargeController::class, 'store']); 


<<<<<<< Updated upstream
//AuthintcTION
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/check_user', [AuthController::class, 'checkUserAndSendOtp']);
Route::post('/reset_password', [AuthController::class, 'checkOtpAndUpdatePassword']);
=======



//AuthintcTION
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
>>>>>>> Stashed changes








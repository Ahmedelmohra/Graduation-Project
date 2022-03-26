<?php

use Illuminate\Support\Facades\Route;
use Google\Cloud\Firestore\FirestoreClient;

use Kreait\Laravel\Firebase\Facades\Firebase;

use App\Http\Controllers\PaymentsController;
// use phpseclib\Crypt\Hash;
// use Hash;
use Illuminate\Support\Facades\Hash;
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

Route::get('/test' , function(){
    // $firestore = new FirestoreClient();

    // $data = $firestore->collection('Service')->documents();
    // dd($data);

    // $users = Firebase::database()->documents();
    // dd($users);

    $pass = 'password';
    $newPass = Hash::make($pass);
    dd($newPass);
    
});

Route::get('/payments' , [PaymentsController::class , 'index']);

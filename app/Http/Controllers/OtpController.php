<?php

namespace App\Http\Controllers;

use App\Models\otp;
use App\Models\client;
use App\Models\wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OtpController extends Controller
{
    /**
     * get all otps
     * 
     * @return array of otp
     */
    public function index ()
    {
        $otp = new Otp();
        $otp = $otp->getAll();
        return $otp;
    }

    /**
     * check otp by user id
     * 
     * @param Request $request
     * @return array
     */
    public function check(Request $request)
    {
        $client_id = $request->client_id;
        // $otp_num  = hash('sha256' , $request->otp_num);
        $otp_num  =  $request->otp_num;
        
        $otp = new otp();
        $client = new client();
        $find_otp = $otp->userOtp($client_id);
        return $find_otp;
    //     if($find_otp){
    //         if((int)$find_otp === (int)$otp_num){
               
    //             $this->createWallet($request);
    //             $this->destroy($request);
    //             return response()->json([
    //                 'status' => true,
    //                 'message' => 'OTP is valid and created wallet'
    //             ]);
    //         }else{
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'OTP is invalid'
    //             ]);
    //             $client->deleteClient($client_id);
    //         }
    //     }else{
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'user not found'
    //         ]);
    //     }
    }

    /**
     * resend otp
     * 
     * @param Request $request
     * @return array
     */
    public function resend(Request $request)
    {
        $this->destroy($request);
        $this->generateOtp($request);
        return response()->json([
            'status' => true,
            'message' => 'OTP is resent successfully'
        ]);

    }

    /**
     * Destroy otp
     * 
     * @param Request $request
     * @return array
     */
    public function destroy(Request $request)
    {
        $client_id = $request->client_id;
        $otp = new otp();
        $otp->deleteOtp($client_id);
    }

    /**
     * generate otp code
     *
     * @param Request $request
     * 
     */
    public function generateOtp(Request $request)
    {
        $random_otp = rand(1000, 9999);
        // $otp_hash = hash('sha256', $random_otp);

        $otp = new otp();
        $otp->create([
            'client_id' => $request->client_id,
            'otp' => $random_otp
        ]);
    }

    /**
     * create wallet
     *
     * @param Request $request
     * 
     */
    public function createWallet(Request $request)
    {
        $otp = new otp();
        $otps = $otp->otp($request->id);
        if ($otps)
            return $otps;
        else
            return response()->json(['error' => 'otp not found'], 404);
    }
}

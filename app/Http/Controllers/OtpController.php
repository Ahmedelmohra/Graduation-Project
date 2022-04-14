<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\otp;
use Illuminate\Support\Facades\Validator;

class OtpController extends Controller
{

     /**
     * check otp by user id
     * 
     * @param Request $request
     * @return array
     */
    public function check(Request $request)
    {
        $user_id = $request->user_id;
        $otp_num  = $request->otp_num; 

        $otp = new Otp();
        $find_otp = $otp->userOtp($user_id);

        if($find_otp){
            if($find_otp == $otp_num){
                return response()->json([
                    'status' => true,
                    'message' => 'OTP is valid'
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'OTP is invalid'
                ]);
            }
        }else{
            return response()->json([
                'status' => false,
                'message' => 'user not found'
            ]);
        }
    }

    /**
     * resend otp
     * 
     * @param Request $request
     * @return array
     */
    public function resend(Request $request)
    {
        $data = $request->all();
        $user_id = $data['user_id'];

        $otp = new Otp();
        $find_otp = $otp->userOtp($user_id);

        if($find_otp){
            $this->generateOtp($user_id);
            return response()->json([
                'status' => true,
                'message' => 'OTP is resend'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'user not found'
            ]);
        }
    }

    /**
     * Destroy otp
     * 
     * @param Request $request
     * @return array
     */
    public function destroy(Request $request)
    {
        $user_id = $request->input('user_id');
        $otp = new Otp();
        $otp->deleteOtp($user_id);
        return response()->json([
            'status' => true,
            'message' => 'OTP is deleted'
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\otp;
use Illuminate\Support\Facades\Validator;

class OtpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $otp = new otp();
        $otps = $otp->getAll();
        return $otps;
    }

    /**
     * Store a newly created resource in storage.
     * 3del ya heshaaaaaam b3d el data
     * 7eta security
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        
        $validator =  Validator::make($request->all(),[
            'otp_number' => 'required|numeric',
            'client_id' => 'required|string',
            // 'company_id' => 'required|numeric',
            // 'network' => 'required|string',
            // 'operation_num' => 'required|numeric',
            // 'service_id' => 'required|string',
            // 'client_id' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => 'validation faild',
                'data' => $validator->errors()
            ], 400);
        }
        else{
            $otp = new otp();
            $createotp = $otp->create($data);
        }
        if ($createotp)
            return response()->json(['success' => true, 'data' => $createotp], 200);
        else
            return response()->json(['error' => 'Something went wrong'], 500);
    }

    /**
     * Display the otp resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $otp = new otp();
        $otp = $otp->find($id);
        if ($otp)
            return $otp;
        else
            return response()->json(['error' => 'otp not found'], 404);
    }

    /**
     * Update the otp resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $validator =  Validator::make($request->all(),[
            'otp_number' => 'required|numeric|max:10',
            'client_id' => 'required|string|max:10',
            // 'company_id' => 'required|numeric',
            // 'network' => 'required|string',
            // 'operation_num' => 'required|numeric',
            // 'service_id' => 'required|string',
            // 'client_id' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => 'validation faild',
                'data' => $validator->errors()
            ], 400);
        }
        else{
            $otp = new otp();
            $updateotp = $otp->edit($id, $data);
        }

        if ($updateotp)
            return $updateotp;
        else
            return response()->json(['error' => 'Something went wrong'], 500);
    }

    /**
     * get all otps of otp
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function otps($id)
    {
        $otp = new otp();
        $otps = $otp->otps($id);
        if ($otps)
            return $otps;
        else
            return response()->json(['error' => 'otp not found'], 404);
}
}

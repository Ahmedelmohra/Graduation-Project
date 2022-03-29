<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\wallet;
use Illuminate\Support\Facades\Validator;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wallet = new wallet();
        $wallet = $wallet->getAll();
        return $wallet;
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
            'balance' => 'required|numeric',
            'client_id' => 'required|string',
            'wallet recharge_id' => 'required|string',
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
            $wallet = new wallet();
            $createwallet = $wallet->create($data);
        }
        if ($createwallet)
            return response()->json(['success' => true, 'data' => $createwallet], 200);
        else
            return response()->json(['error' => 'Something went wrong'], 500);
    }

    /**
     * Display the wallet resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $wallet = new wallet();
        $wallet = $wallet->find($id);
        if ($wallet)
            return $wallet;
        else
            return response()->json(['error' => 'wallet not found'], 404);
    }

    /**
     * Update the wallet resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $validator =  Validator::make($request->all(),[
            'balance' => 'required|numeric',
            'client_id' => 'required|string',
            'wallet recharge_id' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => 'validation faild',
                'data' => $validator->errors()
            ], 400);
        }
        else{
            $wallet = new wallet();
            $updatewallet = $wallet->edit($id, $data);
        }

        if ($updatewallet)
            return $updatewallet;
        else
            return response()->json(['error' => 'Something went wrong'], 500);
    }

    /**
     * get all wallet of wallet
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function wallet($id)
    {
        $wallet = new wallet();
        $wallet = $wallet->wallet($id);
        if ($wallet)
            return $wallet;
        else
            return response()->json(['error' => 'wallet not found'], 404);
}


}

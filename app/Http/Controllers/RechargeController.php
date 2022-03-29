<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\recharge;
use Illuminate\Support\Facades\Validator;

class RechargeController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recharge = new recharge();
        $recharge = $recharge->getAll();
        return $recharge;
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
            'data' => 'required|string',
            'total' => 'required|numeric',
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
            $recharge = new recharge();
            $createrecharge = $recharge->create($data);
        }
        if ($createrecharge)
            return response()->json(['success' => true, 'data' => $createrecharge], 200);
        else
            return response()->json(['error' => 'Something went wrong'], 500);
    }

    /**
     * Display the recharge resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $recharge = new recharge();
        $recharge = $recharge->find($id);
        if ($recharge)
            return $recharge;
        else
            return response()->json(['error' => 'recharge not found'], 404);
    }

    /**
     * Update the recharge resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $validator =  Validator::make($request->all(),[
            'total' => 'required|numeric|max:10',
            'data' => 'required|string|max:10',
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
            $recharge = new recharge();
            $updaterecharge = $recharge->edit($id, $data);
        }

        if ($updaterecharge)
            return $updaterecharge;
        else
            return response()->json(['error' => 'Something went wrong'], 500);
    }

    /**
     * get all recharge of recharge
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function recharge($id)
    {
        $recharge = new recharge();
        $recharge = $recharge->recharge($id);
        if ($recharge)
            return $recharge;
        else
            return response()->json(['error' => 'recharge not found'], 404);
}
}

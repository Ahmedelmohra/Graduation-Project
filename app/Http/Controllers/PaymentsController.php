<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Payment = new Payment();
        $Payments = $Payment->getAll();
        return $Payments;
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
            'price' => 'required|numeric|max:10',
            'service_code' => 'required|string|max:10',
            'company_id' => 'required|numeric',
            // 'network' => 'required|string',
            'operation_num' => 'required|numeric',
            // 'service_id' => 'required|string',
            'client_id' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => 'validation faild',
                'data' => $validator->errors()
            ], 400);
        }
        else{
            $Payment = new Payment();
            $createPayment = $Payment->create($data);
        }
        if ($createPayment)
            return response()->json(['success' => true, 'data' => $createPayment], 200);
        else
            return response()->json(['error' => 'Something went wrong'], 500);
    }

    /**
     * Display the Payment resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Payment = new Payment();
        $Payment = $Payment->find($id);
        if ($Payment)
            return $Payment;
        else
            return response()->json(['error' => 'Payment not found'], 404);
    }

    /**
     * Update the Payment resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $validator =  Validator::make($request->all(),[
            'price' => 'required|numeric|max:10',
            'service_code' => 'required|string|max:10',
            'company_id' => 'required|numeric',
            // 'network' => 'required|string',
            'operation_num' => 'required|numeric',
            // 'service_id' => 'required|string',
            'client_id' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => 'validation faild',
                'data' => $validator->errors()
            ], 400);
        }
        else{
            $Payment = new Payment();
            $updatePayment = $Payment->edit($id, $data);
        }

        if ($updatePayment)
            return $updatePayment;
        else
            return response()->json(['error' => 'Something went wrong'], 500);
    }

    /**
     * get all payments of Payment
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function payments($id)
    {
        $Payment = new Payment();
        $payments = $Payment->payments($id);
        if ($payments)
            return $payments;
        else
            return response()->json(['error' => 'Payment not found'], 404);
}
}
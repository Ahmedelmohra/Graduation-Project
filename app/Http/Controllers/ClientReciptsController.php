<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClientRecipts;
use Illuminate\Support\Facades\Validator;

class ClientReciptsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ClientRecipts = new ClientRecipts();
        $ClientRecipts = $ClientRecipts->getAll();
        return $ClientRecipts;
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        
        $validator =  Validator::make($request->all(),[
            'client_id' => 'required|string|max:255',
            'date' => 'required|string|max:25',
            'payment_id' => 'required|string',
            'price' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => 'validation faild',
                'data' => $validator->errors()
            ], 400);
        }
        else{
            $ClientRecipts = new ClientRecipts();
            $createClientRecipts = $ClientRecipts->create($data);
        }
        if ($createClientRecipts)
            return response()->json(['success' => true, 'data' => $createClientRecipts], 200);
        else
            return response()->json(['error' => 'Something went wrong'], 500);
    }

    /**
     * Display the ClientRecipts resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ClientRecipts = new ClientRecipts();
        $ClientRecipts = $ClientRecipts->find($id);
        if ($ClientRecipts)
            return $ClientRecipts;
        else
            return response()->json(['error' => 'ClientRecipts not found'], 404);
    }

    /**
     * Update the ClientRecipts resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $request->validate([
            'client_id' => 'required|string|max:255',
            'date' => 'required|string|max:25',
            'payment_id' => 'required|string',
            'price' => 'required|string'
        ]);
        $ClientRecipts = new ClientRecipts();
        $updateClientRecipts = $ClientRecipts->edit($id, $data);
        if ($updateClientRecipts)
            return $updateClientRecipts;
        else
            return response()->json(['error' => 'Something went wrong'], 500);
    }

    /**
     * get all payments of ClientRecipts
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function payments($id)
    {
        $ClientRecipts = new ClientRecipts();
        $payments = $ClientRecipts->payments($id);
        if ($payments)
            return $payments;
        else
            return response()->json(['error' => 'ClientRecipts not found'], 404);
    }
}

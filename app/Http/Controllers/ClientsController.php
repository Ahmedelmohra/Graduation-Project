<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\client;
use Illuminate\Support\Facades\Validator;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $client = new client();
        $clients = $client->getAll();
        return $clients;
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
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:25',
            'password' => 'required|string',
            'salt' => 'required|string',
            'finger_print' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => 'validation faild',
                'data' => $validator->errors()
            ], 400);
        }
        else{
            $client = new client();
            $createclient = $client->create($data);
        }
        if ($createclient)
            return response()->json(['success' => true, 'data' => $createclient], 200);
        else
            return response()->json(['error' => 'Something went wrong'], 500);
    }

    /**
     * Display the client resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = new client();
        $client = $client->find($id);
        if ($client)
            return $client;
        else
            return response()->json(['error' => 'client not found'], 404);
    }

    /**
     * Update the client resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:25',
            'password' => 'required|string',
            'salt' => 'required|string'
        ]);
        $client = new client();
        $updateclient = $client->edit($id, $data);
        if ($updateclient)
            return $updateclient;
        else
            return response()->json(['error' => 'Something went wrong'], 500);
    }

    /**
     * get all payments of client
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function payments($id)
    {
        $client = new client();
        $payments = $client->payments($id);
        if ($payments)
            return $payments;
        else
            return response()->json(['error' => 'client not found'], 404);
    }
}

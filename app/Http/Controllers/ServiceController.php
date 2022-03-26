<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Service = new Service();
        $Services = $Service->getAll();
        return $Services;
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
            'image' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => 'validation faild',
                'data' => $validator->errors()
            ], 400);
        }
        else{
            $Service = new Service();
            $createService = $Service->create($data);
        }
        if ($createService)
            return response()->json(['success' => true, 'data' => $createService], 200);
        else
            return response()->json(['error' => 'Something went wrong'], 500);
    }

    /**
     * Display the Service resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Service = new Service();
        $Service = $Service->find($id);
        if ($Service)
            return $Service;
        else
            return response()->json(['error' => 'Service not found'], 404);
    }

    /**
     * Update the Service resource in storage.
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
            'image' => 'required|string|mimes:jpeg,png,jpg'
        ]);
        $Service = new Service();
        $updateService = $Service->edit($id, $data);
        if ($updateService)
            return $updateService;
        else
            return response()->json(['error' => 'Something went wrong'], 500);
    }

    /**
     * get all payments of Service
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function payments($id)
    {
        $Service = new Service();
        $payments = $Service->payments($id);
        if ($payments)
            return $payments;
        else
            return response()->json(['error' => 'Service not found'], 404);
    }
}


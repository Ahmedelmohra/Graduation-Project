<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\client;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->all();
        $clients = new client();

        $validator =  Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:11',
            'password' => 'required|string',
            'salt' => 'string'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], );
        }
        else{
            $client_phone = $clients->findByPhone($data['phone']);
            if ($client_phone){
                return response()->json([
                    'status' => false ,
                    'message' => 'Phone number already exist'
                ], );
            }else{
                $client = $clients->create($data);
                return response()->json([
                    'status' => true,
                    'message' => 'User registered successfully',
                    'data' => [
                         'id' => $client['id'],
                         'name' => $client['data']['name'],
                        'phone' => $client['data']['phone'],
                        
                    ]
                ], );
            }
        }
    }

    /**
     * Login client and create token
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $clients = new client();

        $validator =  Validator::make($request->all(), [
            'phone' => 'required|string|max:11',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'validation failed',
                'data' => $validator->errors()
            ], );
        } else {
            $client = $clients->findByPhone($request->phone);
            if ($client) {
                $client_data = $client->data();
                $client_password = $client_data['password'];
               $request_password = $request->password . $client_data['salt'];
               
                if ($client_password == $request_password) {

                    return response()->json([
                        'status' => true,
                        'message' => 'login success',
                        'data' => [
                            'id' => $client->id(),
                            'name' => $client->data()['name'],
                            'phone' => $client->data()['phone'],
                        ],
                    ], );
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Password is incorrect',
                        'data' => null,
                    ], );
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => ' Phone number is incorrect',
                    'data' => null,
                ],);
              
            }
        }
        
    }
}

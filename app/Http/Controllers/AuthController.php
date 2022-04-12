<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\client;
use App\Models\Company;
use App\Models\otp;
class AuthController extends Controller
{
     /**
     * Register new client.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $data = $request->all();
        $clients = new client();
        $companies = new Company();

        $validator = $this->validateRegisterData($request);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'validation failed',
                'data' => $validator->errors()
            ], );
        }

        if($request->typeOfUser == 'user'){
            $client = $clients->findByPhone($request->phone);
            if ($client) {
                return response()->json([
                    'status' => false,
                    'message' => 'Phone number already exist'
                ]);
            }else{
                $client = $clients->create([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'password' => $request->password,
                    'salt' => $request->salt,
                ]);
                $this->generateOtp($client);
                return response()->json([
                    'status' => true,
                    'message' => 'client registered successfully',
                    'data' => [
                        'id' => $client['id'],
                        'name' => $client['data']['name'],
                        'phone' => $client['data']['phone'],
                    ]
                ]);
            }
        }elseif($request->typeOfUser == 'company'){
            $company = $companies->findByEmail($request->email);
            if ($company) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email Address already exist'
                ]);
            }else{
                $company = $companies->create($data);
                // $this->generateOtp($company);
                return response()->json([
                    'status' => true,
                    'message' => 'Company registered successfully',
                    'data' => [
                        'id' => $company['id'],
                        'name' => $company['data']['name'],
                        'email' => $company['data']['email'],
                        'bank_account' => $company['data']['bank_account'],
                        'commercial' => $company['data']['commercial'],
                        'tax_number' => $company['data']['tax_number'],
                        'personal_id' => $company['data']['personal_id'],
                    ]
                ]);
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
        $companies = new Company();

        $validator = $this->validateLoginData($request);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'validation failed',
                'data' => $validator->errors()
            ]);
        } 

        if($request->typeOfUser == 'user'){
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
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Password is incorrect'
                    ]);
                }
            } else {
                return response()->json(['error' => 'Phone number is incorrect']);
            }
        }elseif($request->typeOfUser == 'company'){
            $company = $companies->findByEmail($request->email);
            if ($company) {
                $company_data = $company->data();
                $company_password = $company_data['password'];
                $request_password = $request->password;
                if ($company_password == $request_password) {
                    return response()->json([
                        'status' => true,
                        'message' => 'login success',
                        'data' => [
                            'id' => $company->id(),
                            'name' => $company->data()['name'],
                            'email' => $company->data()['email'],
                            'bank_account' => $company->data()['bank_account'],
                            'commercial' => $company->data()['commercial'],
                            'tax_number' => $company->data()['tax_number'],
                            'personal_id' => $company->data()['personal_id'],
                        ],
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Password is incorrect'
                    ]);
                }
            } else {
                return response()->json(['error' => 'Email Address is incorrect']);
            }
        }
        
    }

    /**
     * validate Register data
     *
     * @return \Illuminate\Http\Response
     */
    public function validateRegisterData(Request $request)
    {
        if ($request->typeOfUser == 'user') {
            $validator =  Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:11',
                'password' => 'required|string',
                'salt' => 'required|string'
            ]);
        } elseif ($request->typeOfUser == 'company') {
            $validator =  Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|email',
                'password' => 'required|string',
                'bank_account' => 'required|numeric',
                'commercial' => 'required|numeric',
                'tax_number' => 'required|numeric',
                'personal_id' => 'required|numeric',
            ]);
        }
        
        return $validator;
    }

    /**
     * validate Login data
     *
     * @return \Illuminate\Http\Response
     */
    public function validateLoginData(Request $request)
    {
        if ($request->typeOfUser == 'user') {
            $validator =  Validator::make($request->all(), [
                'phone' => 'required|string|max:11',
                'password' => 'required|string',
            ]);
        } elseif ($request->typeOfUser == 'company') {
            $validator =  Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|string',
            ]);
        }

        return $validator;
    }


    /**
     * generate otp code
     *
     * @return \Illuminate\Http\Response
     */
    public function generateOtp($client)
    {
        $random_otp = rand(1000, 9999);
        $otp_hash = hash('sha256', $random_otp);

        $otp = new Otp();
        $otp->create([
            'client_id' => $client['id'],
            'otp' => $otp_hash
        ]);
    }

}

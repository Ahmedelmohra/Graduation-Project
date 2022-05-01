<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\wallet;
use App\Models\client;
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
            return response()->json(['error' => 'wallet not found']);
    }

    /**
     * pay and decrees from wallet.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function payWithWallet(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'client_id' => 'required|string',
            'password' => 'required|string',
            'total' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'validation faild',
                'data' => $validator->errors()
            ]);
        }

        $wallet = new wallet();
        $client = new client();
        $get_client = $client->find($request->client_id);
        $get_wallet = $wallet->findByUserId($request->client_id);
        if ($get_client) {
            $request_password = $request->password . $get_client['data']['salt'];
            if ($request_password == $get_client['data']['password']) {
                if ($get_wallet) {
                    if ((int) $get_wallet->data()['balance'] > (int)$request->total) {
                        $data = [
                            'client_id' => $request->client_id,
                            'balance' => (int) $get_wallet->data()['balance'] - (int)$request->total
                        ];
                        $wallet->edit($get_wallet->id(), $data);
                        return response()->json([
                            'status' => true,
                            'message' => 'Payment done successfully'
                        ]);
                    } else {
                        return response()->json([
                            'status' => false,
                            'message' => 'Not enough balance'
                        ]);
                    }
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Wallet not found'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Password is incorrect'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Client not found'
            ]);
        }
    }

    /**
     * Update the wallet resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $clients = new client();
        $wallets = new wallet();

        $request->validate([
            'phone' => 'required|numeric',
            'password' => 'required|string',
            'balance' => 'required|numeric'
        ]);

        $client = $clients->findByPhone($request->phone);

        if ($client) {
            $client_data = $client->data();
            $client_password = $client_data['password'];
            $request_password = $request->password . $client_data['salt'];
            if ($client_password == $request_password) {
                $wallet = $wallets->findByUserId($client->id());
                $data = [
                    'client_id' => $client->id(),
                    'balance' => $request->balance
                ];
                $wallets->edit($wallet->id() , $data);
                return response()->json([
                    'status' => true,
                    'message' => 'Wallet updated successfully'
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
    }

    
}
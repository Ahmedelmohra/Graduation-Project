<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\company;
use Illuminate\Support\Facades\Validator;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company = new company();
        $company = $company->getAll();
        return $company;
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
            'bank_account' => 'required|string',
            'commercial' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',
            'personal_ID' => 'required|numeric',
            'tax_card' => 'required|string',
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
            $company = new company();
            $createcompany = $company->create($data);
        }
        if ($createcompany)
            return response()->json(['success' => true, 'data' => $createcompany], 200);
        else
            return response()->json(['error' => 'Something went wrong'], 500);
    }

    /**
     * Display the company resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = new company();
        $company = $company->find($id);
        if ($company)
            return $company;
        else
            return response()->json(['error' => 'company not found'], 404);
    }

    /**
     * Update the company resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $validator =  Validator::make($request->all(),[
            'bank_account' => 'required|string',
            'commercial' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',
            'personal_ID' => 'required|numeric',
            'tax_card' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => 'validation faild',
                'data' => $validator->errors()
            ], 400);
        }
        else{
            $company = new company();
            $updatecompany = $company->edit($id, $data);
        }

        if ($updatecompany)
            return $updatecompany;
        else
            return response()->json(['error' => 'Something went wrong'], 500);
    }

    /**
     * get all companys of company
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function companys($id)
    {
        $company = new company();
        $companys = $company->companys($id);
        if ($companys)
            return $companys;
        else
            return response()->json(['error' => 'company not found'], 404);
}
}


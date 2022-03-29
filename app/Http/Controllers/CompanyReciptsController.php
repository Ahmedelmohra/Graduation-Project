<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyRecipts;
use Illuminate\Support\Facades\Validator;


class CompanyReciptsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $CompanyRecipts = new CompanyRecipts();
        $CompanyRecipts = $CompanyRecipts->getAll();
        return $CompanyRecipts;
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
            'payment_id' => 'required|string',
            'data' => 'required|string',
            'company_id' => 'required|string'
          
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => 'validation faild',
                'data' => $validator->errors()
            ], 400);
        }
        else{
            $CompanyRecipts = new CompanyRecipts();
            $createCompanyRecipts = $CompanyRecipts->create($data);
        }
        if ($createCompanyRecipts)
            return response()->json(['success' => true, 'data' => $createCompanyRecipts], 200);
        else
            return response()->json(['error' => 'Something went wrong'], 500);
    }

    /**
     * Display the CompanyRecipts resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $CompanyRecipts = new CompanyRecipts();
        $CompanyRecipts = $CompanyRecipts->find($id);
        if ($CompanyRecipts)
            return $CompanyRecipts;
        else
            return response()->json(['error' => 'CompanyRecipts not found'], 404);
    }

    /**
     * Update the CompanyRecipts resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $validator =  Validator::make($request->all(),[
            'payment_id' => 'required|string',
            'data' => 'required|string',
            'company_id' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => 'validation faild',
                'data' => $validator->errors()
            ], 400);
        }
        else{
            $CompanyRecipts = new CompanyRecipts();
            $updateCompanyRecipts = $CompanyRecipts->edit($id, $data);
        }

        if ($updateCompanyRecipts)
            return $updateCompanyRecipts;
        else
            return response()->json(['error' => 'Something went wrong'], 500);
    }

    /**
     * get all CompanyRecipts of CompanyRecipts
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function CompanyRecipts($id)
    {
        $CompanyRecipts = new CompanyRecipts();
        $CompanyRecipts = $CompanyRecipts->CompanyRecipts($id);
        if ($CompanyRecipts)
            return $CompanyRecipts;
        else
            return response()->json(['error' => 'CompanyRecipts not found'], 404);
}
}



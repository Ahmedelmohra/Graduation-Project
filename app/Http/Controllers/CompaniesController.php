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
     * get all payments by company id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function payments($id)
    {
        $company = new company();
        $company = $company->payments($id);
        return $company;
    }

    /**
     * get company by service
     * 
     * @param $service
     * @return array
     */
    public function findByService(Request $request)
    {
        $service = $request->service;
        $company = new Company();
        $companies = $company->findByService($service);
        return response()->json([
            'id' => $companies->id(),
            'name' => $companies->data()['name'],
        ]);
    }
}


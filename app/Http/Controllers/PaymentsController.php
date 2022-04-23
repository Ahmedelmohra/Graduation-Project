<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Payment;
use App\Models\recipts;
use Google\Cloud\Core\Timestamp;
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $payment = new Payment;

        $validator = Validator::make($request->all(),[
            'company_name' => 'nullable|string',
            'client_id' => 'required|string',
            'service_code' => 'required|numeric',
            'price' => 'required|numeric',
            'feeds' => 'required|numeric',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'validation failed',
                'data' => $validator->errors()
            ]);
        }
        else{
            $company = $this->getCompany($request->company_name);
            $payment = $payment->create([
                'company_id' => $company->id(),
                'client_id' => $request->client_id,
                'service_code' => $request->service_code,
                'price' => $request->price,
                'feeds' => $request->feeds,
            ]);
            $receipt = $this->createReceipt($payment , $request->feeds);
            return response()->json([
                'status' => true,
                'message' => 'Payment created successfully',
                'data' => [
                    'id' => $payment->id(),
                    'company_name' => $company->data()['name'],
                    'client_id' => $payment->data()['client_id'],
                    'service_code' => (int) $payment->data()['service_code'],
                    'price' => $payment->data()['price'],
                    'receipt' => [
                        'id' => $receipt->id(),
                        'payment_id' => $receipt->data()['payment_id'],
                        'feeds' => $receipt->data()['feeds'],
                        'total' => $receipt->data()['total'],
                        'date' => $receipt->data()['date']->get()->format('Y-m-d H:i:s'),
                    ]
                ]
            ]);
        }
        
    }

    /**
     * Create receipt for payment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function createReceipt($payment , $feeds)
    {
        $receipt = new recipts();
        $total = (int) $payment['price'] + (int) $feeds;
        $now_date = new Timestamp(new \DateTime('now'));

        $receipt = $receipt->create([
            'payment_id' => $payment->id(),
            'feeds' => $feeds,
            'total' => number_format($total, 2),
            'date' => $now_date
        ]);

        return $receipt;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payment = new Payment();
        $payment = $payment->find($id);
        if ($payment)
            return $payment;
        else
            return response()->json(['error' => 'Payment not found']);
    }

    /**
     * get caompany by id
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getCompany($name)
    {
        $company = new Company();
        $company = $company->findByName($name);
        return $company->data()['name'];
    }
}
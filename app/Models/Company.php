<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Google\Cloud\Firestore\FirestoreClient;

class Company extends Model
{
    use HasFactory;

    public $firstore;
    public $collection;
    public $documents;

    public function __construct()
    {
        $this->firstore = new FirestoreClient();
        $this->collection = $this->firstore->collection('companies');
        $this->documents = $this->collection->documents()->rows();
    }

    /**
     * get all payment
     * 
     * @return array of payment`
     */
    public function getAll()
    {
        $documents =  $this->documents;
        $payment = [];
        foreach ($documents as $document) {
            $id = $document->id();
            $payment[] = [
                'id' => $id,
                'data' => $document->data()
            ];
        }
        return $payment;
    }

    /**
     * get client by id
     * 
     * @param  int $id
     * @return array of client
     */
    public function find($id){
        $document = $this->collection->document($id)->snapshot();
        if ($document->exists()) {
            $client = [
                'id' => $document->id(),
                'data' => $document->data()
            ];
            return $client;
        }
        return false;
    }

    /**
     * create client
     * 
     * @param  array $data
     * @return array of client
     */
    public function create(array $data){
        $document = $this->collection->add($data);
        return $document->snapshot();
    }

    /**
     * update client
     * 
     * @param  int $id
     * @param  array $data
     * @return array of client
     */
    public function edit ($id, array $data){
        $document = $this->collection->document($id);
        $document->set($data);
        return $document->snapshot();
    }

    /**
     * get receipts by company id
     * 
     * @param  int $id
     * @return array of receipts
     */
    public function payments($id)
    {
        $collection = $this->firstore->collection('payments');
        $documents = $collection->where('company_id', '==', $id)->documents()->rows();
        $payments = [];
        foreach ($documents as $document) {
            $id = $document->id();
            $receipt = new Receipt();
            $get_receipt = $receipt->payment($id);
            $payments[] = [
                'id' => $document->id(),
                'user_id' => $document->data()['user_id'],
                'company_id' => $document->data()['company_id'],
                'service_code' => $document->data()['service_code'],
                'price' => $document->data()['price'],
                'receipt' => [
                    'id' => $get_receipt->id(),
                    'payment_id' => $get_receipt->data()['payment_id'],
                    'feeds' => $get_receipt->data()['feeds'],
                    'total' => $get_receipt->data()['total'],
                    'date' => $get_receipt->data()['date']->get()->format('Y-m-d H:i:s'),
                ]
            ];
        }
        return $payments;
    }

}


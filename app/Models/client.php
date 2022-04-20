<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\client as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Google\Cloud\Firestore\Firestoreclient;
use App\Models\recipts;
use App\Models\Company;

class client extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    public $firstore;
    public $collection;
    public $documents;

    public function __construct()
    {
        $this->firstore = new Firestoreclient();
        $this->collection = $this->firstore->collection('clients');
        $this->documents = $this->collection->documents()->rows();
    }

    /**
     * get all clients
     * 
     * @return array of clients
     */
    public function getAll()
    {
        $documents =  $this->documents;
        $clients = [];
        foreach ($documents as $document) {
            $id = $document->id();
            $clients[] = [
                'id' => $id,
                'data' => $document->data()
            ];
        }
        return $clients;
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

   /* get user by phone
     * 
     * @param  int $id
     * @return array of user
     */
    public function findByPhone($phone){
        $collection = $this->collection->where('phone', '=', $phone);
        $documents = $collection->documents();
        if ($documents->rows() != null) {
            $document = $documents->rows()[0];
            return $document;
        }
    }

    /**
     * create client
     * 
     * @param  array $data
     * @return array of client
     */
    public function create(array $data){
        $document = $this->collection->add($data);
        return [
            'id' => $document->id(),
            'data' => $document->snapshot()->data()
        ];
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
     * get receipts by client id
     * 
     * @param  int $id
     * @return array of receipts
     */
    public function payments($id)
    {
        $collection = $this->firstore->collection('payments');
        $documents = $collection->where('client_id', '==', $id)->documents()->rows();
        $payments = [];
        foreach ($documents as $document) {
            $id = $document->id();
            $receipt = new recipts();
            $company = new Company();
            $company_name = $company->find($document->data()['company_id']);
            $get_receipt = $receipt->payment($id);
            $payments[] = [
                'id' => $document->id(),
                'company_name' => $company_name['data']['name'],
                'total' => $get_receipt->data()['total'],
                'date' => $get_receipt->data()['date']->get()->format('Y-m-d H:i:s'),
                // 'user_id' => $document->data()['user_id'],
                // 'service_code' => $document->data()['service_code'],
                // 'price' => $document->data()['price'],
                // 'receipt' => [
                //     'id' => $get_receipt->id(),
                //     // 'payment_id' => $get_receipt->data()['payment_id'],
                //     // 'feeds' => $get_receipt->data()['feeds'],
                //     'total' => $get_receipt->data()['total'],
                //     'date' => $get_receipt->data()['date']->get()->format('Y-m-d H:i:s'),
                // ]
            ];
        }
        return $payments;
    }

    /**
     * get wallet by client id
     * 
     * @param  int $id
     * @return array of wallet
     * 
     */
    public function wallet($id)
    {
        $collection = $this->firstore->collection('wallets');
        $documents = $collection->where('client_id', '==', $id)->documents();
        if ($documents->rows() != null) {
            $document = $documents->rows()[0];
            return $document;
        }

        return false;
    }

    /**
     * delete all users
     * 
     * @return bool
     */
    public function deleteAll()
    {
        $documents = $this->collection->documents();
        foreach ($documents as $document) {
            $item = $this->collection->document($document->id());
            $item->delete();
        }

        return true;
    }


}

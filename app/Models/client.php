<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\client as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Google\Cloud\Firestore\Firestoreclient;

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

    public function __Ibrahim()
    {
        // cosom ezz 
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
     * delete client
     * 
     * @param  int $id
     * @return array of client
     */
    public function payments($id)
    {
        $collection = $this->firstore->collection('payments');
        $documents = $collection->where('client_id', '==', $id)->documents()->rows();
        $payments = [];
        foreach ($documents as $document) {
            $payments[] = [
                'id' => $document->id(),
                'data' => $document->data()
            ];
        }
        return $payments;
    }


    public function recipts($id)
    {
        $collection = $this->firstore->collection('recipts');
        $documents = $collection->where('client_id', '==', $id)->documents()->rows();
        $recipts = [];
        foreach ($documents as $document) {
            $recipts[] = [
                'id' => $document->id(),
                'data' => $document->data()
            ];
        }
        return $recipts;
    }
    public function wallet($id)
    {
        $collection = $this->firstore->collection('wallets');
        $documents = $collection->where('client_id', '==', $id)->documents()->rows();
        $wallet = [];
        foreach ($documents as $document) {
            $wallet[] = [
                'id' => $document->id(),
                'data' => $document->data()
            ];
        }

        return $wallet;
    }


}
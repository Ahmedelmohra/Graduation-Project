<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Google\Cloud\Firestore\FirestoreClient;

class ClientRecipts extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    public $firstore;
    public $collection;
    public $documents;

    public function __construct()
    {
        $this->firstore = new FirestoreClient();
        $this->collection = $this->firstore->collection('client_recipts');
        $this->documents = $this->collection->documents()->rows();
    }

    /**
     * get all ClientRecipts
     * 
     * @return array of ClientRecipts
     */
    public function getAll()
    {
        $documents =  $this->documents;
        $ClientRecipts = [];
        foreach ($documents as $document) {
            $id = $document->id();
            $ClientRecipts[] = [
                'id' => $id,
                'data' => $document->data()
            ];
        }
        return $ClientRecipts;
    }

    /**
     * get Client by id
     * 
     * @param  int $id
     * @return array of Client
     */
    public function find($id){
        $document = $this->collection->document($id)->snapshot();
        if ($document->exists()) {
            $Client = [
                'Client_id' => $document->id(),
                'data' => $document->data()
            ];
            return $ClientRecipts;
        }
        return false;
    }

    /**
     * create ClientRecipts
     * 
     * @param  array $data
     * @return array of ClientRecipts
     */
    public function create(array $data){
        $document = $this->collection->add($data);
        return $document->snapshot();
    }

    /**
     * update ClientRecipts
     * 
     * @param  int $id
     * @param  array $data
     * @return array of ClientRecipts
     */
    public function edit ($id, array $data){
        $document = $this->collection->document($id);
        $document->set($data);
        return $document->snapshot();
    }

    /**
     * delete ClientRecipts
     * 
     * @param  int $id
     * @return array of ClientRecipts
     */
    public function payments($id)
    {
        $collection = $this->firstore->collection('payments');
        $documents = $collection->where('ClientRecipts_id', '==', $id)->documents()->rows();
        $payments = [];
        foreach ($documents as $document) {
            $payments[] = [
                'id' => $document->id(),
                'data' => $document->data()
            ];
        }
        return $payments;
    }

}

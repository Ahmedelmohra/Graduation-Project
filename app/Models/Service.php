<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Google\Cloud\Firestore\FirestoreClient;

class Service extends Model
{
    use HasFactory;
    public $firstore;
    public $collection;
    public $documents;

    public function __construct()
    {
        $this->firstore = new FirestoreClient();
        $this->collection = $this->firstore->collection('Service');
        $this->documents = $this->collection->documents()->rows();
    }

    /**
     * get all Service
     * 
     * @return array of Service
     */
    public function getAll()
    {
        $documents =  $this->documents;
        $Service = [];
        foreach ($documents as $document) {
            $id = $document->id();
            $Service[] = [
                'id' => $id,
                'data' => $document->data()
            ];
        }
        return $Service;
    }

    /**
     * get user by id
     * 
     * @param  int $id
     * @return array of user
     */
    public function find($id){
        $document = $this->collection->document($id)->snapshot();
        if ($document->exists()) {
            $user = [
                'id' => $document->id(),
                'data' => $document->data()
            ];
            return $user;
        }
        return false;
    }

    /**
     * create user
     * 
     * @param  array $data
     * @return array of user
     */
    public function create(array $data){
        $document = $this->collection->add($data);
        return $document->snapshot();
    }

    /**
     * update user
     * 
     * @param  int $id
     * @param  array $data
     * @return array of user
     */
    public function edit ($id, array $data){
        $document = $this->collection->document($id);
        $document->set($data);
        return $document->snapshot();
    }

    /**
     * delete user
     * 
     * @param  int $id
     * @return array of user
     */
    public function payments($id)
    {
        $collection = $this->firstore->collection('payments');
        $documents = $collection->where('user_id', '==', $id)->documents()->rows();
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


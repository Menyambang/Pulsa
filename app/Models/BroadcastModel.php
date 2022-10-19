<?php namespace App\Models;

use App\Models\MyModel;

class BroadcastModel extends MyModel
{
    protected $table = "m_broadcast";
    protected $primaryKey = "brdId";
    protected $createdField = "brdCreatedAt";
    protected $updatedField = "brdUpdatedAt";
    protected $returnType = "App\Entities\Broadcast";
    protected $allowedFields = ["brdJudul","brdDeskripsi","brdGambar","brdUrl","brdDeletedAt"];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }
}
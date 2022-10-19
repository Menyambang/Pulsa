<?php namespace App\Models;

use App\Models\MyModel;

class MetodePembayaranModel extends MyModel
{
    protected $table = "m_metode_pembayaran";
    protected $primaryKey = "mpbId";
    protected $createdField = "mpbCreatedAt";
    protected $updatedField = "mpbUpdatedAt";
    protected $returnType = "App\Entities\MetodePembayaran";
    protected $allowedFields = ["mpbNama","mpbDeskripsi","mpbTipe","mpbGambar","mpbVaNumber","mpbRekNumber","mpbBank","mpbDeletedAt"];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }
}
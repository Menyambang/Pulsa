<?php namespace App\Models;

use App\Models\MyModel;

class KategoriModel extends MyModel
{
    protected $table = "m_kategori";
    protected $primaryKey = "ktgId";
    protected $createdField = "ktgCreatedAt";
    protected $updatedField = "ktgUpdatedAt";
    protected $returnType = "App\Entities\Kategori";
    protected $allowedFields = ["ktgNama","ktgIcon","ktgDeletedAt"];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }
}
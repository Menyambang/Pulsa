<?php namespace App\Models;

use App\Models\MyModel;

class KategoriMenuModel extends MyModel
{
    protected $table = "t_kategori_menu";
    protected $primaryKey = "ktmId";
    protected $createdField = "ktmCreatedAt";
    protected $updatedField = "ktmUpdatedAt";
    protected $returnType = "App\Entities\KategoriMenu";
    protected $allowedFields = ["ktmKtgId","ktmMenuId","ktmDeletedAt"];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }
}
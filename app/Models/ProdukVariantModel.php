<?php namespace App\Models;

use App\Models\MyModel;

class ProdukVariantModel extends MyModel
{
    protected $table = "t_produk_variant";
    protected $primaryKey = "pvarId";
    protected $createdField = "pvarCreatedAt";
    protected $updatedField = "pvarUpdatedAt";
    protected $returnType = "App\Entities\ProdukVariant";
    protected $allowedFields = ["pvarProdukId","pvarStok","pvarProdukStok","pvarHarga","pvarGambar","pvarNama","pvarDeletedAt"];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }
}
<?php namespace App\Models;

use App\Models\MyModel;

class ProdukGambarModel extends MyModel
{
    protected $table = "t_produk_gambar";
    protected $primaryKey = "prdgbrId";
    protected $createdField = "prdgbrCreatedAt";
    protected $updatedField = "prdgbrUpdatedAt";
    protected $returnType = "App\Entities\ProdukGambar";
    protected $allowedFields = ["prdgbrProdukId", "prdgbrIsThumbnail","prdgbrFile","prdgbrDeletedAt"];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }
}
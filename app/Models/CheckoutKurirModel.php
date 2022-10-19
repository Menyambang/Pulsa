<?php namespace App\Models;

use App\Models\MyModel;

class CheckoutKurirModel extends MyModel
{
    protected $table = "t_checkout_kurir";
    protected $primaryKey = "ckurId";
    protected $createdField = "ckurCreatedAt";
    protected $updatedField = "ckurUpdatedAt";
    protected $returnType = "App\Entities\CheckoutKurir";
    protected $allowedFields = ["ckurCheckoutId","ckurKurir","ckurNama","ckurService","ckurDeskripsi","ckurCost","ckurTipePengiriman", "ckurCodId","ckurNoResi","ckurDeletedAt"];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }
}
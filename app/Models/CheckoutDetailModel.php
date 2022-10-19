<?php namespace App\Models;

use App\Models\MyModel;

class CheckoutDetailModel extends MyModel
{
    protected $table = "t_checkout_detail";
    protected $primaryKey = "cktdtId";
    protected $createdField = "cktdtCreatedAt";
    protected $updatedField = "cktdtUpdatedAt";
    protected $returnType = "App\Entities\CheckoutDetail";
    protected $allowedFields = ["cktdtCheckoutId","cktdtKeterangan","cktdtBiaya","cktdtDeletedAt"];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }
}
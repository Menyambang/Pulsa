<?php namespace App\Models;

use App\Models\MyModel;

class KodeOtpModel extends MyModel
{
    protected $table = "t_kode_otp";
    protected $primaryKey = "ktId";
    protected $createdField = "ktCreatedAt";
    protected $updatedField = "ktUpdatedAt";
    protected $returnType = "App\Entities\KodeOtp";
    protected $allowedFields = ["ktPhoneNumber","ktOtpCode","ktDeletedAt"];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }
}
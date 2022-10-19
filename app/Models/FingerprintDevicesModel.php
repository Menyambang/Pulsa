<?php namespace App\Models;

use App\Models\MyModel;

class FingerprintDevicesModel extends MyModel
{
    protected $table = "m_fingerprint_devices";
    protected $primaryKey = "fdId";
    protected $createdField = "fdCreatedAt";
    protected $updatedField = "fdUpdatedAt";
    protected $returnType = "App\Entities\FingerprintDevices";
    protected $allowedFields = ["fdUserEmail","fdDeviceId","fdDeletedAt"];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }
}
<?php namespace App\Models;

use App\Models\MyModel;

class ServiceCenterModel extends MyModel
{
    protected $table = "m_service_center";
    protected $primaryKey = "scId";
    protected $createdField = "scCreatedAt";
    protected $updatedField = "scUpdatedAt";
    protected $returnType = "App\Entities\ServiceCenter";
    protected $allowedFields = ["scNama","scFoto","scWhatsapp","scNoHp","scTelegram","scLatitude","scLongitude","scDeletedAt"];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }
}
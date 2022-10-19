<?php namespace App\Models;

use App\Models\MyModel;

class UserWebModel extends MyModel
{
    protected $table = "m_user_web";
    protected $primaryKey = "usrwebUsername";
    protected $createdField = "usrwebCreatedAt";
    protected $updatedField = "usrwebUpdatedAt";
    protected $returnType = "App\Entities\UserWeb";
    protected $allowedFields = ["usrwebUsername", "usrwebNama", "usrwebRole", "usrwebPassword","usrwebDeletedAt"];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }
}
<?php namespace App\Models;

use App\Models\MyModel;

class NotifikasiToModel extends MyModel
{
    protected $table = "t_notifikasi_to";
    protected $primaryKey = "tnotifId";
    protected $createdField = "tnotifCreatedAt";
    protected $updatedField = "tnotifUpdatedAt";
    protected $returnType = "App\Entities\NotifikasiTo";
    protected $allowedFields = ["tnotifEmail","tnotifNotifId","tnotifIsRead","tnotifDeletedAt"];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }
}
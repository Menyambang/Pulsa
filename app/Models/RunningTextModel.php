<?php namespace App\Models;

use App\Models\MyModel;

class RunningTextModel extends MyModel
{
    protected $table = "m_running_text";
    protected $primaryKey = "rtId";
    protected $createdField = "rtCreatedAt";
    protected $updatedField = "rtUpdatedAt";
    protected $returnType = "App\Entities\RunningText";
    protected $allowedFields = ["rtPesan","rtStatus","rtExpired","rtDeletedAt"];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }
}
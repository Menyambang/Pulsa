<?php namespace App\Models;

use App\Models\MyModel;

class SettingModel extends MyModel
{
    const API_URL_KEY = 'api_url';
    const API_SECRET_KEY = 'api_key';
    const MAX_OTP = 'max_otp';

    protected $table = "m_setting";
    protected $primaryKey = "setKey";
    protected $createdField = "setCreatedAt";
    protected $updatedField = "setUpdatedAt";
    protected $returnType = "App\Entities\Setting";
    protected $allowedFields = ["setKey","setValue","setDeletedAt"];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }

    public function getAllSettingKey(){
        $data = $this->find();

        $res = [];
        foreach ($data as $key => $value) {
            $res[$value->key] = $value->value;
        }

        return $res;
    }

    public function getValue($key){
        $this->where('setKey', $key);
        return $this->first()->value ?? '';
    }

    public function saveKeyValue($key, $value){
        $this->replace( [
            'setKey' => $key,
            'setValue' => $value
        ]);
    }
}
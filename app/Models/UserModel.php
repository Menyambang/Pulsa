<?php namespace App\Models;

use App\Entities\FingerprintDevices;
use App\Models\MyModel;

class UserModel extends MyModel
{
    protected $table = "m_user";
    protected $primaryKey = "usrEmail";
    protected $createdField = "usrCreatedAt";
    protected $updatedField = "usrUpdatedAt";
    protected $returnType = "App\Entities\User";
    // protected $useSoftDeletes = true;
    protected $allowedFields = ["usrEmail","usrNama","usrPassword","usrSaldo","usrPoin","usrIsActive","usrDeletedAt","usrFirebaseToken","usrPin", "usrNoHp", "usrNoWa", "usrActiveCode", "usrOtpCode", "usrLatitude", "usrLongitude",  'usrUsername', 'usrJk', 'usrTglLahir', 'usrBio', 'usrFoto', 'usrFotoKtp'];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }

    protected function relationships()
    {
        return [
            'alamat' => ['table' => 'm_user_alamat', 'condition' => 'usralUsrEmail = usrEmail', 'entity' => 'App\Entities\UserAlamat'],
            'fingerprint' => ['table' => 'm_fingerprint_devices', 'condition' => 'fdUserEmail = usrEmail', 'entity' => FingerprintDevices::class, 'type' => 'left'],
        ];
    }
}
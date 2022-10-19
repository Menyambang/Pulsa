<?php namespace App\Models;

use App\Models\MyModel;

class UserAlamatModel extends MyModel
{
    protected $table = "m_user_alamat";
    protected $primaryKey = "usralId";
    protected $createdField = "usralCreatedAt";
    protected $updatedField = "usralUpdatedAt";
    protected $returnType = "App\Entities\UserAlamat";
    protected $allowedFields = ["usralUsrEmail","usralNama", "usralJalan", "usralDeletedAt","usralLatitude","usralLongitude","usralKotaId","usralKotaNama","usralProvinsiId","usralProvinsiNama","usralKotaTipe","usralKecamatanId","usralKecamatanNama","usralIsActive","usralIsFirst","usralKeterangan"];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }
}
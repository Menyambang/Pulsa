<?php

namespace App\Entities;

use App\Entities\MyEntity;

class User extends MyEntity
{
    protected $casts = [
        'alamat' => 'json',
        'fingerprint' => 'json',
    ];

    protected $datamap = [
        'email' => 'usrEmail',
        'nama' => 'usrNama',
        'password' => 'usrPassword',
        'saldo' => 'usrSaldo',
        'poin' => 'usrPoin',
        'isActive' => 'usrIsActive',
        'createdAt' => 'usrCreatedAt',
        'updatedAt' => 'usrUpdatedAt',
        'deletedAt' => 'usrDeletedAt',
        'firebaseToken' => 'usrFirebaseToken',
        'pin' => 'usrPin',
        'noHp' => 'usrNoHp',
        'noWa' => 'usrNoWa',
        'activeCode' => 'usrActiveCode',
        'otpCode' => 'usrOtpCode',
        'latitude' => 'usrLatitude',
        'longitude' => 'usrLongitude',
        'username' => 'usrUsername',
        'jk' => 'usrJk',
        'tglLahir' => 'usrTglLahir',
        'bio' => 'usrBio',
        'foto' => 'usrFoto',
        'fotoKtp' => 'usrFotoKtp',
    ];

    protected $show = [
        'email',
        'nama',
        // 'password',
        'saldo',
        'poin',
        'isActive',
        'createdAt',
        'updatedAt',
        'deletedAt',
        'firebaseToken',
        'pin',
        'noHp',
        'noWa',
        'activeCode',
        'otpCode',
        'latitude',
        'longitude',
        'alamat',
        'username',
        'jk',
        'tglLahir',
        'bio',
        'foto',
        'fotoKtp',
        'fingerprint',
    ];

    public function hashPassword($password)
    {
        $key = '219404f55e15877401282a82cb16d6b7';
        return md5(md5($password) . $key);
    }

    public function verifyPassword($password)
    {
        return $this->password === $this->hashPassword($password);
    }
}

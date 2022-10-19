<?php namespace App\Entities;
use App\Entities\MyEntity;

class UserWeb extends MyEntity
{
    protected $datamap = [
        'username' => 'usrwebUsername',
        'nama' => 'usrwebNama',
        'password' => 'usrwebPassword',
        'role' => 'usrwebRole',
        'createdAt' => 'usrwebCreatedAt',
        'updatedAt' => 'usrwebUpdatedAt',
        'deletedAt' => 'usrwebDeletedAt',
    ];

    protected $show = [
			'username',
			'nama',
			'role',
			'password',
			'createdAt',
			'updatedAt',
			'deletedAt',
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
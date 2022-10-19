<?php namespace App\Entities;
use App\Entities\MyEntity;

class FingerprintDevices extends MyEntity
{
    protected $datamap = [
        'id' => 'fdId',
        'userEmail' => 'fdUserEmail',
        'deviceId' => 'fdDeviceId',
        'createdAt' => 'fdCreatedAt',
        'updatedAt' => 'fdUpdatedAt',
        'deletedAt' => 'fdDeletedAt',
    ];

    protected $show = [
		'id',
		'userEmail',
		'deviceId',
		'createdAt',
		'updatedAt',
		'deletedAt',
    ];
}
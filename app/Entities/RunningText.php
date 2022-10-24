<?php namespace App\Entities;
use App\Entities\MyEntity;

class RunningText extends MyEntity
{
    protected $datamap = [
        'id' => 'rtId',
        'pesan' => 'rtPesan',
        'status' => 'rtStatus',
        'expired' => 'rtExpired',
        'createdAt' => 'rtCreatedAt',
        'updatedAt' => 'rtUpdatedAt',
        'deletedAt' => 'rtDeletedAt',
    ];

    protected $show = [
		'id',
		'pesan',
		'status',
		'expired',
		'createdAt',
		'updatedAt',
		'deletedAt',
    ];
}
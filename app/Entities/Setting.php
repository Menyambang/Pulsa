<?php namespace App\Entities;
use App\Entities\MyEntity;

class Setting extends MyEntity
{
    protected $datamap = [
        'key' => 'setKey',
        'value' => 'setValue',
        'createdAt' => 'setCreatedAt',
        'updatedAt' => 'setUpdatedAt',
        'deletedAt' => 'setDeletedAt',
    ];

    protected $show = [
		'key',
		'value',
		'createdAt',
		'updatedAt',
		'deletedAt',
    ];
}
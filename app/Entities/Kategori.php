<?php namespace App\Entities;
use App\Entities\MyEntity;

class Kategori extends MyEntity
{
    protected $datamap = [
        'id' => 'ktgId',
        'nama' => 'ktgNama',
        'icon' => 'ktgIcon',
        'createdAt' => 'ktgCreatedAt',
        'updatedAt' => 'ktgUpdatedAt',
        'deletedAt' => 'ktgDeletedAt',
    ];

    protected $show = [
		'id',
'nama',
'icon',
'createdAt',
'updatedAt',
'deletedAt',

    ];
}
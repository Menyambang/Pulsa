<?php namespace App\Entities;
use App\Entities\MyEntity;

class ServiceCenter extends MyEntity
{
    protected $datamap = [
        'id' => 'scId',
        'nama' => 'scNama',
        'foto' => 'scFoto',
        'whatsapp' => 'scWhatsapp',
        'noHp' => 'scNoHp',
        'telegram' => 'scTelegram',
        'latitude' => 'scLatitude',
        'longitude' => 'scLongitude',
        'createdAt' => 'scCreatedAt',
        'updatedAt' => 'scUpdatedAt',
        'deletedAt' => 'scDeletedAt',
    ];

    protected $show = [
		'id',
		'nama',
		'foto',
		'whatsapp',
		'noHp',
		'telegram',
		'latitude',
		'longitude',
		'createdAt',
		'updatedAt',
		'deletedAt',
    ];
}
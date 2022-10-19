<?php namespace App\Entities;
use App\Entities\MyEntity;

class LokasiCod extends MyEntity
{
    protected $datamap = [
        'id' => 'lcdId',
        'nama' => 'lcdNama',
        'latitude' => 'lcdLatitude',
        'longitude' => 'lcdLongitude',
        'createdAt' => 'lcdCreatedAt',
        'updatedAt' => 'lcdUpdatedAt',
        'deletedAt' => 'lcdDeletedAt',
    ];

    protected $show = [
		'id',
		'nama',
		'latitude',
		'longitude',
		'jarak',
		'biaya',
		'createdAt',
		'updatedAt',
		'deletedAt',
    ];
}
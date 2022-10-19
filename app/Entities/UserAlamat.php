<?php namespace App\Entities;
use App\Entities\MyEntity;

class UserAlamat extends MyEntity
{
    protected $datamap = [
        'id' => 'usralId',
        'usrEmail' => 'usralUsrEmail',
        'nama' => 'usralNama',
        'createdAt' => 'usralCreatedAt',
        'updatedAt' => 'usralUpdatedAt',
        'deletedAt' => 'usralDeletedAt',
        'latitude' => 'usralLatitude',
        'longitude' => 'usralLongitude',
        'kotaId' => 'usralKotaId',
        'kotaNama' => 'usralKotaNama',
        'provinsiId' => 'usralProvinsiId',
        'provinsiNama' => 'usralProvinsiNama',
        'kotaTipe' => 'usralKotaTipe',
        'kecamatanId' => 'usralKecamatanId',
        'kecamatanNama' => 'usralKecamatanNama',
        'isActive' => 'usralIsActive',
        'isFirst' => 'usralIsFirst',
        'keterangan' => 'usralKeterangan',
        'jalan' => 'usralJalan',
    ];

    protected $show = [
		'id',
		'usrEmail',
		'nama',
		'createdAt',
		'updatedAt',
		'deletedAt',
		'latitude',
		'longitude',
		'kotaId',
		'kotaNama',
		'provinsiId',
		'provinsiNama',
		'kotaTipe',
		'kecamatanId',
		'kecamatanNama',
		'isActive',
		'isFirst',
    'keterangan',
    'jalan',
    ];
}
<?php namespace App\Entities;
use App\Entities\MyEntity;

class MetodePembayaran extends MyEntity
{
    protected $datamap = [
        'id' => 'mpbId',
        'nama' => 'mpbNama',
        'deskripsi' => 'mpbDeskripsi',
        'tipe' => 'mpbTipe',
        'gambar' => 'mpbGambar',
        'vaNumber' => 'mpbVaNumber',
        'rekNumber' => 'mpbRekNumber',
        'bank' => 'mpbBank',
        'createdAt' => 'mpbCreatedAt',
        'updatedAt' => 'mpbUpdatedAt',
        'deletedAt' => 'mpbDeletedAt',
    ];

    protected $show = [
		'id',
		'nama',
		'deskripsi',
		'tipe',
		'gambar',
		'vaNumber',
		'rekNumber',
		'bank',
		'createdAt',
		'updatedAt',
		'deletedAt',
    ];
}
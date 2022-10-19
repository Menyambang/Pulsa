<?php namespace App\Entities;
use App\Entities\MyEntity;

class Broadcast extends MyEntity
{
    protected $datamap = [
        'id' => 'brdId',
        'judul' => 'brdJudul',
        'deskripsi' => 'brdDeskripsi',
        'gambar' => 'brdGambar',
        'url' => 'brdUrl',
        'createdAt' => 'brdCreatedAt',
        'updatedAt' => 'brdUpdatedAt',
        'deletedAt' => 'brdDeletedAt',
    ];

    protected $show = [
		'id',
		'judul',
		'deskripsi',
		'gambar',
		'url',
		'createdAt',
		'updatedAt',
		'deletedAt',
    ];
}
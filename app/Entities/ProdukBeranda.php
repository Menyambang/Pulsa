<?php namespace App\Entities;
use App\Entities\MyEntity;

class ProdukBeranda extends MyEntity
{
    protected $casts = [
        'products'=>'json',
    ];

    protected $datamap = [
        'id' => 'pbId',
        'banner' => 'pbBanner',
        'judul' => 'pbJudul',
        'deskripsi' => 'pbDeskripsi',
        'updatedAt' => 'pbUpdatedAt',
        'deletedAt' => 'pbDeletedAt',
        'createdAt' => 'pbCreatedAt',
    ];

    protected $show = [
		'id',
		'banner',
		'judul',
		'products',
		'deskripsi',
		'updatedAt',
		'deletedAt',
		'createdAt',
    ];
}
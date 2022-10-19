<?php namespace App\Entities;
use App\Entities\MyEntity;

class MenuDigital extends MyEntity
{
    protected $datamap = [
        'id' => 'mdId',
        'kelompok' => 'mdKelompok',
        'nama' => 'mdNama',
        'icon' => 'mdIcon',
        'urutan' => 'mdUrutan',
        'jenisMenu' => 'mdJenisMenu',
        'showHome' => 'mdShowHome',
        'enabled' => 'mdEnabled',
        'kodeProdukPPOB' => 'mdKodeProdukPPOB',
        'createdAt' => 'mdCreatedAt',
        'updatedAt' => 'mdUpdatedAt',
        'deletedAt' => 'mdDeletedAt',
    ];

    protected $show = [
		'id',
		'kelompok',
		'nama',
		'icon',
		'urutan',
		'jenisMenu',
		'showHome',
		'enabled',
    'kodeProdukPPOB',
		'createdAt',
		'updatedAt',
		'deletedAt',
    ];
}
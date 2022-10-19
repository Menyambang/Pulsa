<?php namespace App\Entities;
use App\Entities\MyEntity;

class KategoriPulsa extends MyEntity
{
  protected $casts = [
    'produk'=>'json',
    'menu'=>'json',
  ];

    protected $datamap = [
        'id' => 'kpId',
        'prefix' => 'kpPrefix',
        'nama' => 'kpNama',
        'icon' => 'kpIcon',
        'urutan' => 'kpUrutan',
        'menuId' => 'kpMenuId',
        'createdAt' => 'kpCreatedAt',
        'updatedAt' => 'kpUpdatedAt',
        'deletedAt' => 'kpDeletedAt',
    ];

    protected $show = [
		'id',
		'prefix',
		'nama',
		'icon',
		'urutan',
		'menuId',
		'produk',
		'menu',
		'createdAt',
		'updatedAt',
		'deletedAt',
    ];
}
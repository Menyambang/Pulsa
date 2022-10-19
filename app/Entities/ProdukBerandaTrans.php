<?php namespace App\Entities;
use App\Entities\MyEntity;

class ProdukBerandaTrans extends MyEntity
{
  protected $casts = [
    'produk'=>'json',
];

    protected $datamap = [
        'id' => 'tpbId',
        'produkId' => 'tpbProdukId',
        'pbId' => 'tpbPbId',
        'updatedAt' => 'tpbUpdatedAt',
        'deletedAt' => 'tpbDeletedAt',
        'createdAt' => 'tpbCreatedAt',
    ];

    protected $show = [
		'id',
		'produkId',
		'pbId',
    'produk',
		'updatedAt',
		'deletedAt',
		'createdAt',
    ];
}
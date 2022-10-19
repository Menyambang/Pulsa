<?php namespace App\Entities;
use App\Entities\MyEntity;

class ProdukVariant extends MyEntity
{
    protected $datamap = [
        'id' => 'pvarId',
        'produkId' => 'pvarProdukId',
        'stok' => 'pvarStok',
        'produkStok' => 'pvarProdukStok',
        'harga' => 'pvarHarga',
        'gambar' => 'pvarGambar',
        'nama' => 'pvarNama',
        'createdAt' => 'pvarCreatedAt',
        'updatedAt' => 'pvarUpdatedAt',
        'deletedAt' => 'pvarDeletedAt',
    ];

    protected $show = [
		'id',
		'produkId',
		'stok',
		'produkStok',
		'harga',
		'gambar',
		'nama',
		'createdAt',
		'updatedAt',
		'deletedAt',
    ];
}
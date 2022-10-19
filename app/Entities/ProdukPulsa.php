<?php namespace App\Entities;
use App\Entities\MyEntity;

class ProdukPulsa extends MyEntity
{
    protected $casts = [
      'kategori'=>'json',
    ];

    protected $datamap = [
        'id' => 'ppId',
        'kategoriId' => 'ppKpId',
        'kode' => 'ppKode',
        'nama' => 'ppNama',
        'deskripsi' => 'ppDeskripsi',
        'urutan' => 'ppUrutan',
        'kodeSuplier' => 'ppKodeSuplier',
        'jenis' => 'ppJenis',
        'poin' => 'ppPoin',
        'jamOperasionalStart' => 'ppJamOperasionalStart',
        'jamOperasionalEnd' => 'ppJamOperasionalEnd',
        'harga' => 'ppHarga',
        'saranHarga' => 'ppSaranHarga',
        'createdAt' => 'ppCreatedAt',
        'updatedAt' => 'ppUpdatedAt',
        'deletedAt' => 'ppDeletedAt',
    ];

    protected $show = [
		'id',
		'kategoriId',
		'kode',
		'nama',
		'deskripsi',
		'urutan',
		'kodeSuplier',
		'jenis',
		'poin',
		'jamOperasionalStart',
		'jamOperasionalEnd',
		'harga',
		'saranHarga',
		'kategori',
		'createdAt',
		'updatedAt',
		'deletedAt',
    ];
}
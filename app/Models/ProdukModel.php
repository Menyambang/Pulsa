<?php

namespace App\Models;

use App\Entities\Kategori;
use App\Entities\ProdukVariant;
use App\Entities\ProdukGambar;
use App\Models\MyModel;

class ProdukModel extends MyModel
{
    protected $table = "m_produk";
    protected $primaryKey = "produkId";
    protected $createdField = "produkCreatedAt";
    protected $updatedField = "produkUpdatedAt";
    protected $returnType = "App\Entities\Produk";
    protected $allowedFields = ["produkId", "produkNama", "produkDeskripsi", "produkHarga", "produkStok", "produkHargaPer", "produkBerat", "produkDilihat", "produkKategoriId", "produkDiskon", "produkDeletedAt"];

    public function getReturnType()
    {
        return $this->returnType;
    }

    public function getPrimaryKeyName()
    {
        return $this->primaryKey;
    }

    protected function relationships()
    {
        return [
            'kategori' => $this->belongsTo('m_kategori', Kategori::class, 'produkKategoriId = ktgId', 'kategori'),
            'variant' => $this->hasMany('t_produk_variant', ProdukVariant::class, 'pvarProdukId = produkId', 'variant', 'pvarProdukId'),
            'gambar' => $this->hasMany('t_produk_gambar', ProdukGambar::class, 'prdgbrProdukId = produkId', 'gambar', 'prdgbrProdukId'),
        ];
    }
}

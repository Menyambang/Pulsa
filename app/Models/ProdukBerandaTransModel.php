<?php namespace App\Models;

use App\Models\MyModel;
use App\Entities\Produk;
use App\Entities\Kategori;
use App\Entities\ProdukGambar;

class ProdukBerandaTransModel extends MyModel
{
    protected $table = "t_produk_beranda";
    protected $primaryKey = "tpbId";
    protected $createdField = "tpbCreatedAt";
    protected $updatedField = "tpbUpdatedAt";
    protected $returnType = "App\Entities\ProdukBerandaTrans";
    protected $allowedFields = ["tpbProdukId","tpbPbId","tpbDeletedAt"];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }

    protected function relationships()
    {
        return [
            'produk' => $this->belongsTo('m_produk', Produk::class, 'tpbProdukId = produkId', 'produk', 'produkId', 'left', function ($relation) {
                // return $relation->hasMany('t_produk_variant', ProdukVariant::class, 'pvarProdukId = produkId', 'variant', 'pvarProdukId');
            }, function ($relation) {
                return $relation->hasMany('t_produk_gambar', ProdukGambar::class, 'prdgbrProdukId = produkId', 'gambar', 'prdgbrProdukId');
            }, function ($relation) {
                return $relation->belongsTo('m_kategori', Kategori::class, 'ktgId = produkKategoriId', 'kategori', 'ktgId');
            }),
        ];

        return [
            'produk' => ['table' => 'm_produk', 'condition' => 'tpbProdukId = produkId', 'entity' => 'App\Entities\Produk'],
        ];
    }

    // public function withGambarProduk(){
    //     return $this->hasMany("t_produk_gambar","produkId = prdgbrProdukId",ProdukGambar::class,"gambar",'prdgbrId');
    // }
}
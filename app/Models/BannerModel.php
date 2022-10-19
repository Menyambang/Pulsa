<?php namespace App\Models;

use App\Models\MyModel;
use App\Entities\Produk;
use App\Entities\Kategori;
use App\Entities\ProdukGambar;

class BannerModel extends MyModel
{
    protected $table = "m_banner";
    protected $primaryKey = "bnrId";
    protected $createdField = "bnrCreatedAt";
    protected $updatedField = "bnrUpdatedAt";
    protected $returnType = "App\Entities\Banner";
    protected $allowedFields = ["bnrDeskripsi","bnrGambar","bnrUrl", "bnrJenis", "bnrKategoriId", "bnrProdukId", "bnrType", "bnrDeletedAt"];

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
            'kategori' => $this->belongsTo('m_kategori', Kategori::class, 'bnrKategoriId = ktgId', 'kategori2'),
            'produk' => $this->belongsTo('m_produk', Produk::class, 'bnrProdukId = produkId', 'produk', 'produkId', 'LEFT', function($relation){
                return $relation->hasMany('t_produk_gambar', ProdukGambar::class, 'prdgbrProdukId = produkId', 'gambar', 'prdgbrProdukId');
            }, function ($relation) {
                return $relation->belongsTo('m_kategori ktg', Kategori::class, 'kategori.ktgId = produkKategoriId', 'kategori', 'ktgId');
            }),
        ];
    }

    public function selectJenis(){
        $select= [];
        foreach (['Kategori', 'Produk', 'Artikel'] as $key => $value) {
            $select[$value] = $value;
        }

        return $select;
    }

    public function selectTipe(){
        $select= [];
        foreach (['Vertical', 'Horizontal'] as $key => $value) {
            $select[$value] = $value;
        }

        return $select;
    }
}
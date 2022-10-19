<?php

namespace App\Models;

use App\Models\MyModel;
use App\Entities\Produk;
use App\Entities\Kategori;
use App\Entities\ProdukGambar;
use App\Entities\ProdukVariant;
use App\Entities\ProdukWKategori;
use App\Entities\ProdukBerandaTrans;

class ProdukBerandaModel extends MyModel
{
    protected $table = "m_produk_beranda";
    protected $primaryKey = "pbId";
    protected $createdField = "pbCreatedAt";
    protected $updatedField = "pbUpdatedAt";
    protected $returnType = "App\Entities\ProdukBeranda";
    protected $allowedFields = ["pbBanner", "pbJudul", "pbDeskripsi", "pbDeletedAt"];

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
        // TODO: JSON jadi sring jika variant bernilai null
        // $variantQuery = "SELECT *,
        //     JSON_ARRAYAGG(JSON_OBJECT(" . $this->entityToMysqlObject(ProdukVariant::class) . ")) AS variant
        //     FROM `t_produk_variant` 
        //     GROUP BY pvarProdukId";

        // $gambarQuery = "SELECT *,
        //         JSON_ARRAYAGG(JSON_OBJECT(" . $this->entityToMysqlObject(ProdukGambar::class) . ")) AS gambars
        //         FROM `t_produk_gambar` 
        //         GROUP BY prdgbrProdukId";

        // $kategoriQuery = "SELECT *,
        //         (JSON_OBJECT(" . $this->entityToMysqlObject(Kategori::class) . ")) AS kategori
        //         FROM `m_kategori` 
        //         GROUP BY ktgId";

        // $productsQuery = "SELECT *,
        //         JSON_ARRAYAGG(JSON_OBJECT(" . $this->entityToMysqlObject(Produk::class) . ", 
        //         'gambar', JSON_EXTRACT(gambar.gambars,'$'), 
        //         'kategori', JSON_EXTRACT(kategori.kategori,'$')
        //         /* ,'variant', JSON_EXTRACT(variant.variant,'$') */
        //         )) AS products
        //         FROM `t_produk_beranda` 
        //         JOIN `m_produk` p ON `tpbProdukId` = p.`produkId`
        //         JOIN (" . $gambarQuery . ") gambar ON gambar.prdgbrProdukId = p.produkId 
        //         JOIN (" . $kategoriQuery . ") kategori ON kategori.ktgId = p.produkKategoriId 
        //         /* LEFT JOIN (" . $variantQuery . ") variant ON variant.pvarProdukId = produkId  */
        //         GROUP BY tpbPbId";

        return [
            'products' => $this->hasMany('(SELECT * FROM `t_produk_beranda` JOIN `m_produk` p ON `tpbProdukId` = p.`produkId`) as products', Produk::class, 'tpbPbId = pbId', 'products', 'tpbPbId', 'left', function ($relation) {
                // return $relation->hasMany('t_produk_variant', ProdukVariant::class, 'pvarProdukId = produkId', 'variant', 'pvarProdukId');
            }, function ($relation) {
                return $relation->hasMany('t_produk_gambar', ProdukGambar::class, 'prdgbrProdukId = produkId', 'gambar', 'prdgbrProdukId');
            }, function ($relation) {
                return $relation->belongsTo('m_kategori', Kategori::class, 'ktgId = produkKategoriId', 'kategori', 'ktgId');
            }),
        ];

        // return [
        //     'products' => ['table' => "({$productsQuery})", 'condition' => 'tpbPbId = pbId', 'field_json' => "JSON_EXTRACT(products,'$')", 'type' => 'left'],
        // ];
    }

    // public function withProduk()
    // {
    //     return $this->hasMany("(SELECT * FROM `t_produk_beranda` tpb JOIN `m_produk` p ON  tpb.`tpbProdukId` = p.`produkId`) as produk","tpbPbId = pbId",Produk::class,"products",'-');
    // }

    /**
     * NOT USED
     *
     * @param [type] $idProdukBeranda
     * @return void
     */
    // public function getDetailProdukBeranda($idProdukBeranda = null)
    // {
    //     $this->select('*');
    //     $this->withProduk();
    //     $data = $this->find($idProdukBeranda);
    //     // echo '<pre>';
    //     // print_r($this->getLastQuery()->getQuery());
    //     // echo '</pre>';exit;

    //     if (is_array($data)) {
    //         $data = array_map(function ($e) {
    //             $e = $e;
    //             $e->products = array_map(function ($produk) {
    //                 $produkGambarModel = new ProdukGambarModel();
    //                 $kategoriModel = new KategoriModel();
    //                 $produk->kategori = $kategoriModel->find($produk->kategoriId);
    //                 $produk->gambar = $produkGambarModel->where(['prdgbrProdukId' => $produk->id])->find();
    //                 return $produk;
    //             }, $e->products);
    //             return $e;
    //         }, $data);
    //     } else if (!empty($data)) {
    //         $data->products = array_map(function ($produk) {
    //             $produkGambarModel = new ProdukGambarModel();
    //             $kategoriModel = new KategoriModel();
    //             $produk->kategori = $kategoriModel->find($produk->kategoriId);

    //             $produk->gambar = $produkGambarModel->where(['prdgbrProdukId' => $produk->id])->find();
    //             return $produk;
    //         }, $data->products);
    //         return $data;
    //     }

    //     return $data;
    // }
}

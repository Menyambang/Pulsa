<?php namespace App\Models;

use App\Models\MyModel;
use App\Entities\Produk;
use App\Entities\Kategori;
use App\Entities\NotifikasiTo;
use App\Entities\ProdukGambar;

class NotifikasiModel extends MyModel
{
    protected $table = "m_notifikasi";
    protected $primaryKey = "noitfId";
    protected $createdField = "";
    protected $updatedField = "";
    protected $returnType = "App\Entities\Notifikasi";
    protected $allowedFields = ["notifJudul","notifPesan","notifType","notifGambar","notifProdukId"];

    protected function relationships()
    {
        return [
            'produk' => $this->belongsTo('m_produk', Produk::class, 'notifProdukId = produkId', 'produk', 'produkId', 'left', function ($relation) {
                // return $relation->hasMany('t_produk_variant', ProdukVariant::class, 'pvarProdukId = produkId', 'variant', 'pvarProdukId');
            }, function ($relation) {
                return $relation->hasMany('t_produk_gambar', ProdukGambar::class, 'prdgbrProdukId = produkId', 'gambar', 'prdgbrProdukId');
            }, function ($relation) {
                return $relation->belongsTo('m_kategori', Kategori::class, 'ktgId = produkKategoriId', 'kategori', 'ktgId');
            }),
            'penerima' => $this->belongsTo('t_notifikasi_to', NotifikasiTo::class, 'tnotifNotifId = notifId', 'penerima', 'tnotifNotifId'),
        ];
    }

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }
}
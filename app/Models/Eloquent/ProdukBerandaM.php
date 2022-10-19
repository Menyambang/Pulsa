<?php 

namespace App\Models\Eloquent;
use Illuminate\Database\Eloquent\Model;

class ProdukBerandaM extends Model
{
    protected $table = 'm_produk_beranda';
    protected $primaryKey = 'pbId';

    public function produk() {
        return $this->belongsToMany(ProdukM::class, 't_produk_beranda','tpbPbId','tpbProdukId')->with('gambar');
    }
}
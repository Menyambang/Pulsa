<?php 

namespace App\Models\Eloquent;
use Illuminate\Database\Eloquent\Model;

class ProdukM extends Model
{
    protected $table = 'm_produk';
    protected $primaryKey = 'produkId';

    public function gambar() {
        return $this->hasMany(ProdukGambarM::class,  'prdgbrProdukId','produkId');
    }
}
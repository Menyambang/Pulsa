<?php namespace App\Models;

use App\Models\MyModel;
use App\Entities\UserSaldo;
use App\Entities\ProdukPulsa;
use App\Entities\KategoriPulsa;

class CheckoutPulsaModel extends MyModel
{
    protected $table = "t_checkout_pulsa";
    protected $primaryKey = "cktpId";
    protected $createdField = "cktpCreatedAt";
    protected $updatedField = "cktpUpdatedAt";
    protected $returnType = "App\Entities\CheckoutPulsa";
    protected $allowedFields = ["cktpEmail","cktpUsalId","cktpIdProduk","cktpStatus","cktpTujuan"];

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
            'pembayaran' => ['table' => 't_user_saldo', 'condition' => 'cktpUsalId = usalId', 'entity' => UserSaldo::class],
            'produk' => $this->belongsTo('m_produk_pulsa', ProdukPulsa::class, 'cktpIdProduk = ppId', 'produk', 'ppId', 'LEFT', function($e){
                return $this->belongsTo('m_kategori_pulsa', KategoriPulsa::class, 'kpId = ppKpId', 'kategori', 'kpId');
            }),
        ];
    }
}
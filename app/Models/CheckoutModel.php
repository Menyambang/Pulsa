<?php namespace App\Models;

use App\Models\MyModel;
use App\Entities\LokasiCod;
use App\Entities\CheckoutKurir;
use App\Entities\CheckoutDetail;
use App\Entities\User;

class CheckoutModel extends MyModel
{
    protected $table = "t_checkout";
    protected $primaryKey = "cktId";
    protected $createdField = "cktCreatedAt";
    protected $updatedField = "cktUpdatedAt";
    protected $returnType = "App\Entities\Checkout";
    protected $allowedFields = ["cktStatus","cktPmbId","cktKurir","cktNoResiKurir","cktCatatan","cktAlamatId", "ckurTipePengiriman", "cktDeletedAt"];

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
            'pembayaran' => ['table' => 't_pembayaran', 'condition' => 'cktPmbId = pmbId', 'entity' => 'App\Entities\Pembayaran'],
            'kurir' =>  $this->belongsTo('t_checkout_kurir', CheckoutKurir::class, 'cktId = ckurCheckoutId', 'kurir', null, 'LEFT', function($e){
                return $e->belongsTo('m_lokasi_cod', LokasiCod::class, 'lcdId = ckurCodId', 'lokasiCod');
            }),
            'alamat' => ['table' => 'm_user_alamat', 'condition' => 'cktAlamatId = usralId', 'entity' => 'App\Entities\UserAlamat'],
            'user' => ['table' => 'm_user', 'condition' => 'usrEmail = usralUsrEmail', 'entity' => User::class],
            'detail' => $this->hasMany('t_checkout_detail', CheckoutDetail::class, 'cktId = cktdtCheckoutId', 'detail', 'cktdtCheckoutId','LEFT'),
        ];
    }
}
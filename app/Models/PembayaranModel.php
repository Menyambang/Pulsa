<?php namespace App\Models;

use App\Models\MyModel;

class PembayaranModel extends MyModel
{
    protected $table = "t_pembayaran";
    protected $primaryKey = "pmbId";
    protected $createdField = "";
    protected $updatedField = "";
    protected $returnType = "App\Entities\Pembayaran";
    protected $allowedFields = ["pmbId","pmbPaymentCode", "pmbPaymentType", "pmbStore", "pmbStatus","pmbTime","pmbSignatureKey","pmbOrderId","pmbMerchantId","pmbGrossAmount","pmbCurrency","pmbVaNumber","pmbRekNumber","pmbBank","pmbBillerCode","pmbBillKey","pmbUserEmail","pmbExpiredDate"];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }

    // public function updatePembayaranToExpired(){
    //     $this->whereIn('pmbPaymentType', ['cod', 'manual_transfer']);
    //     $this->where('pmbStatus', 'pending');
    //     $this->where('pmbExpiredDate <', date('Y-m-d H:i:s'));
    //     $data = $this->find();

    //     foreach ($data as $value) {
    //         $this->update($value->id, ['pmbStatus' => 'expire']);
    //     }
    //     return $data;
    // }
}
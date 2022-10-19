<?php namespace App\Models;

use App\Models\MyModel;

class UserSaldoModel extends MyModel
{
    protected $table = "t_user_saldo";
    protected $primaryKey = "usalId";
    protected $createdField = "";
    protected $updatedField = "";
    protected $returnType = "App\Entities\UserSaldo";
    protected $allowedFields = ["usalId", "usalPaymentType", "usalPaymentCode", "usalStore", "usalStatus","usalTime","usalSignatureKey","usalOrderId","usalMerchantId","usalGrossAmount","usalCurrency","usalVaNumber", "usalRekNumber", "usalBank","usalBillerCode","usalBillKey","usalUserEmail",'usalStatusSaldo','usalPoin','usalExpiredDate',];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }

    public function addSaldo($transId){
        $transData = $this->find($transId);

        $userEmail = $transData->userEmail;
        $grossAmount = $transData->grossAmount;
        if($transData->status == 'settlement'){
            $modelUser = new UserModel();
            $data = $modelUser->find($userEmail);
            
            $usrSaldo = doubleval($data->saldo) + doubleval($grossAmount);
            $modelUser->update($userEmail, [
                'usrSaldo' => $usrSaldo,
            ]);
          
        }
    }
}
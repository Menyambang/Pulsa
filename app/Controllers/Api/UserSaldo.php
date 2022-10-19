<?php namespace App\Controllers\Api;

use App\Controllers\MyResourceController;
/**
 * Class UserSaldo
 * @note Resource untuk mengelola data t_user_saldo
 * @dataDescription t_user_saldo
 * @package App\Controllers
 */
class UserSaldo extends MyResourceController
{
    protected $modelName = 'App\Models\UserSaldoModel';
    protected $format    = 'json';

    protected $rulesCreate = [
       'paymentType' => ['label' => 'paymentType', 'rules' => 'required'],
       'status' => ['label' => 'status', 'rules' => 'required'],
       'time' => ['label' => 'time', 'rules' => 'required'],
       'signatureKey' => ['label' => 'signatureKey', 'rules' => 'required'],
       'orderId' => ['label' => 'orderId', 'rules' => 'required'],
       'merchantId' => ['label' => 'merchantId', 'rules' => 'required'],
       'grossAmount' => ['label' => 'grossAmount', 'rules' => 'required'],
       'currency' => ['label' => 'currency', 'rules' => 'required'],
       'vaNumber' => ['label' => 'vaNumber', 'rules' => 'required'],
       'bank' => ['label' => 'bank', 'rules' => 'required'],
       'billerCode' => ['label' => 'billerCode', 'rules' => 'required'],
       'billKey' => ['label' => 'billKey', 'rules' => 'required'],
       'userEmail' => ['label' => 'userEmail', 'rules' => 'required'],
   ];

    protected $rulesUpdate = [
       'paymentType' => ['label' => 'paymentType', 'rules' => 'required'],
       'status' => ['label' => 'status', 'rules' => 'required'],
       'time' => ['label' => 'time', 'rules' => 'required'],
       'signatureKey' => ['label' => 'signatureKey', 'rules' => 'required'],
       'orderId' => ['label' => 'orderId', 'rules' => 'required'],
       'merchantId' => ['label' => 'merchantId', 'rules' => 'required'],
       'grossAmount' => ['label' => 'grossAmount', 'rules' => 'required'],
       'currency' => ['label' => 'currency', 'rules' => 'required'],
       'vaNumber' => ['label' => 'vaNumber', 'rules' => 'required'],
       'bank' => ['label' => 'bank', 'rules' => 'required'],
       'billerCode' => ['label' => 'billerCode', 'rules' => 'required'],
       'billKey' => ['label' => 'billKey', 'rules' => 'required'],
       'userEmail' => ['label' => 'userEmail', 'rules' => 'required'],
   ];

   public function index(){
       $userEmail = $this->user['email'];
       $this->model->where('usalUserEmail', $userEmail);

       return parent::index();
   }
}
